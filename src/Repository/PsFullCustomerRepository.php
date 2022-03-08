<?php

namespace App\Repository;

use App\Entity\PsFullCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PsFullCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PsFullCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PsFullCustomer[]    findAll()
 * @method PsFullCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PsFullCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PsFullCustomer::class);
    }

    // /**
    //  * @return PsFullCustomer[] Returns an array of PsFullCustomer objects
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
    public function findOneBySomeField($value): ?PsFullCustomer
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
