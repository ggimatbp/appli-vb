<?php

namespace App\Repository;

use App\Entity\ApCatalogCustomerBp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogCustomerBp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogCustomerBp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogCustomerBp[]    findAll()
 * @method ApCatalogCustomerBp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogCustomerBpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogCustomerBp::class);
    }

    // /**
    //  * @return ApCatalogCustomerBp[] Returns an array of ApCatalogCustomerBp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ApCatalogCustomerBp
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
