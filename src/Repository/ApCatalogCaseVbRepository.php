<?php

namespace App\Repository;

use App\Entity\ApCatalogCaseVb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogCaseVb|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogCaseVb|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogCaseVb[]    findAll()
 * @method ApCatalogCaseVb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogCaseVbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogCaseVb::class);
    }

    // /**
    //  * @return ApCatalogCaseVb[] Returns an array of ApCatalogCaseVb objects
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

    public function findAllOrderName()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?ApCatalogCaseVb
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
