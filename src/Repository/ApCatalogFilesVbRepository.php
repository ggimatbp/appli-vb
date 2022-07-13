<?php

namespace App\Repository;

use App\Entity\ApCatalogFilesVb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogFilesVb|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogFilesVb|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogFilesVb[]    findAll()
 * @method ApCatalogFilesVb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogFilesVbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogFilesVb::class);
    }

    // /**
    //  * @return ApCatalogFilesVb[] Returns an array of ApCatalogFilesVb objects
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
    public function findOneBySomeField($value): ?ApCatalogFilesVb
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findFilesBySectors($id): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.sector = :id')
            ->setParameter('id', $id)
            ->orderBy('a.orderNumber', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllFileByCaseId($id):array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.caseId = :id' )
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBiggestOrderNumberBySectorsForPdf($id)
    {
    return $this->createQueryBuilder('a')
    ->andWhere('a.file_type LIKE :pdf')
    ->setParameter('pdf', '%pdf%')
    ->andWhere('a.caseId = :id' )
    ->setParameter('id', $id)
    ->orderBy('a.orderNumber', 'DESC')
    ->getQuery()->setMaxresults(1)
    ->getResult()
    ;
    }

    public function findBiggestOrderNumberBySectorsForOther($id)
    {
    return $this->createQueryBuilder('a')
    ->andWhere('a.file_type != :pdf')
    ->setParameter('pdf', 'pdf')
    ->andWhere('a.caseId = :id' )
    ->setParameter('id', $id)
    ->orderBy('a.orderNumber', 'DESC')
    ->getQuery()->setMaxresults(1)
    ->getResult()
    ;
    }
}
