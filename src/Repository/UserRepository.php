<?php

namespace App\Repository;

use App\Entity\Gender;
use App\Entity\User;
use App\Entity\UserPreference;
use App\Repository\Interface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int[] $alreadySeenIds
     *
     * @throws Exception
     * @throws NonUniqueResultException
     */
    public function getUserMatch(UserPreference $currentUserPreference, ?array $alreadySeenIds): ?User
    {
        // dodać dobieranie poprzez hobby oraz poprzez odległość od zamieszkania (redis)
        // aktualne dobieranie polega na przedziale wiekowym i preferowanych płciach
        $genderIds = $currentUserPreference->getGenders()->map(function (Gender $gender) {
            return $gender->getId();
        })->toArray();

        $queryBuilder = $this->createQueryBuilder('u');

        return $queryBuilder
            ->innerJoin('u.sex', 'g')
            ->where('u.age BETWEEN :minAge AND :maxAge')
            ->andWhere($queryBuilder->expr()->in('g.id', ':genders'))
            ->andWhere($queryBuilder->expr()->notIn('u.id', ':excludedIds'))
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->setParameters([
                    'genders' => $currentUserPreference->getGenders()->map(function (Gender $gender) {
                        return $gender->getId();
                    })->toArray(),
                    'minAge' => $currentUserPreference->getLowerAgeRange(),
                    'maxAge' => $currentUserPreference->getUpperAgeRange(),
                    'excludedIds' => $alreadySeenIds,
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getRandomUser(int $currentUserId): User
    {
        return $this->createQueryBuilder('u')
            ->addSelect('RAND() as HIDDEN rand')
            ->where('u.id <> :userId')
            ->orderBy('rand')
            ->setMaxResults(1)
            ->setParameter('userId', $currentUserId)
            ->getQuery()
            ->getResult()[0];
    }
}
