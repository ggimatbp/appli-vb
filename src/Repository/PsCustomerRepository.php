<?php

namespace App\Repository;

use App\Entity\PsCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PsCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PsCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PsCustomer[]    findAll()
 * @method PsCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PsCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PsCustomer::class);
    }

    // /**
    //  * @return PsCustomer[] Returns an array of PsCustomer objects
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
    public function findOneBySomeField($value): ?PsCustomer
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
