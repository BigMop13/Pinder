<?php

namespace App\Repository;

use App\Entity\Gender;
use App\Entity\Hobby;
use App\Entity\User;
use App\Entity\UserPreference;
use App\Repository\Interface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @return User[]
     */
    public function getUserMatches(UserPreference $currentUserPreference): array
    {
        // dodać dobieranie poprzez hobby oraz poprzez odległość od zamieszkania (redis)
        // aktualne dobieranie polega na przedziale wiekowym i preferowanych płciach
        $qb = $this->createQueryBuilder('u');

        $qb->select('u.id as id, g.id as genderId, u.age')
            ->innerJoin('u.sex', 'g')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->between('u.age', ':minAge', ':maxAge'),
                    $qb->expr()->in('g', ':genders'),
                )
            )
            ->setParameters([
                'minAge' => $currentUserPreference->getLowerAgeRange(),
                'maxAge' => $currentUserPreference->getUpperAgeRange(),
                'genders' => $currentUserPreference->getGenders()->map(function (Gender $gender) {
                    return $gender->getId();
                })->toArray(),
            ]);

        return $qb->getQuery()->getResult();
    }
}
