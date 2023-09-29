<?php

namespace App\Repository;

use App\Entity\Gender;
use App\Entity\User;
use App\Entity\UserPreference;
use App\Repository\Interface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
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
     * @throws Exception
     * @param int[] $alreadySeenIds
     */
    public function getUserMatch(UserPreference $currentUserPreference, array $alreadySeenIds): User
    {
        // dodać dobieranie poprzez hobby oraz poprzez odległość od zamieszkania (redis)
        // aktualne dobieranie polega na przedziale wiekowym i preferowanych płciach
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = '
            SELECT u.id, u.age
            FROM user u
            INNER JOIN gender g ON u.sex_id = g.id
            WHERE u.age BETWEEN :minAge AND :maxAge
              AND g.id IN (:genders)
              AND u.id >= FLOOR(RAND() * (SELECT MAX(id) FROM user))
              AND u.id NOT IN (:excludedIds)
            ORDER BY u.id
            LIMIT 1
        ';

        $genderIds = $currentUserPreference->getGenders()->map(function (Gender $gender) {
            return $gender->getId();
        })->toArray();

        $statement = $connection->prepare($sql);

        $result = $statement->executeQuery([
            'minAge' => $currentUserPreference->getLowerAgeRange(),
            'maxAge' => $currentUserPreference->getUpperAgeRange(),
            'genders' => implode(',', $genderIds),
            'excludedIds' => implode(',', $alreadySeenIds),
        ])->fetchAllAssociative()[0];

        return $this->find($result['id']);
    }

    public function getRandomUser(): User
    {
        return $this->createQueryBuilder('u')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }
}
