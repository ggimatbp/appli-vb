<?php

namespace App\Repository;

use App\Entity\ApCatalogFilesBpHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogFilesBpHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogFilesBpHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogFilesBpHistory[]    findAll()
 * @method ApCatalogFilesBpHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogFilesBpHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogFilesBpHistory::class);
    }

    // /**
    //  * @return ApCatalogFilesBpHistory[] Returns an array of ApCatalogFilesBpHistory objects
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
    public function findOneBySomeField($value): ?ApCatalogFilesBpHistory
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
