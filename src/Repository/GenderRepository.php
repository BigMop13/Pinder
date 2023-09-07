<?php

namespace App\Repository;

use App\Entity\Gender;
use App\Repository\Interface\GenderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gender>
 *
 * @method Gender|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gender|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gender[]    findAll()
 * @method Gender[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenderRepository extends ServiceEntityRepository implements GenderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gender::class);
    }

    /**
     * @param int[] $genderIds
     * @return Gender[]
     */
    public function getHobbiesFromArrayOfIds(array $genderIds): array
    {
        return $this->createQueryBuilder('g')
            ->where('g.id IN (:ids)')
            ->setParameter('ids', $genderIds)
            ->getQuery()
            ->getResult();
    }
}
