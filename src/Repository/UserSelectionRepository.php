<?php

namespace App\Repository;

use App\Entity\UserSelection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserSelection>
 *
 * @method UserSelection|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSelection|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSelection[]    findAll()
 * @method UserSelection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSelectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSelection::class);
    }
}
