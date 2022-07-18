<?php

namespace App\Repository;

use App\Entity\ApCatalogFilesBp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogFilesBp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogFilesBp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogFilesBp[]    findAll()
 * @method ApCatalogFilesBp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogFilesBpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogFilesBp::class);
    }

    // /**
    //  * @return ApCatalogFilesBp[] Returns an array of ApCatalogFilesBp objects
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
    public function findOneBySomeField($value): ?ApCatalogFilesBp
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllById($id): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.model = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFilesBySectors($id): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.relation = :id')
            ->setParameter('id', $id)
            ->orderBy('a.orderNumber', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    public function findBiggestOrderNumberBySectorsForPdf($id)
    {
    return $this->createQueryBuilder('a')
    ->andWhere('a.fileType LIKE :pdf')
    ->setParameter('pdf', '%pdf%')
    ->andWhere('a.relation = :id' )
    ->setParameter('id', $id)
    ->orderBy('a.orderNumber', 'DESC')
    ->getQuery()->setMaxresults(1)
    ->getResult()
    ;
    }

    public function findBiggestOrderNumberBySectorsForOther($id)
    {
    return $this->createQueryBuilder('a')
    ->andWhere('a.fileType != :pdf')
    ->setParameter('pdf', 'pdf')
    ->andWhere('a.relation = :id' )
    ->setParameter('id', $id)
    ->orderBy('a.orderNumber', 'DESC')
    ->getQuery()->setMaxresults(1)
    ->getResult()
    ;
    }

}
