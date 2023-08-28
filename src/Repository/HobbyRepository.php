<?php

namespace App\Repository;

use App\Entity\Hobby;
use App\Repository\Interface\HobbyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hobby>
 *
 * @method Hobby|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hobby|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hobby[]    findAll()
 * @method Hobby[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HobbyRepository extends ServiceEntityRepository implements HobbyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hobby::class);
    }

    /**
     * @param int[] $hobbyIds
     *
     * @return Hobby[]
     */
    public function getHobbiesFromArrayOfIds(array $hobbyIds): array
    {
        return $this->createQueryBuilder('h')
            ->where('h.id IN (:ids)')
            ->setParameter('ids', $hobbyIds)
            ->getQuery()
            ->getResult();
    }
}
