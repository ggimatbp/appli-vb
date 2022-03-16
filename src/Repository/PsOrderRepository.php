<?php

namespace App\Repository;

use App\Entity\PsOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PsOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PsOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PsOrder[]    findAll()
 * @method PsOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PsOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PsOrder::class);
    }

    // /**
    //  * @return PsOrder[] Returns an array of PsOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PsOrder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
