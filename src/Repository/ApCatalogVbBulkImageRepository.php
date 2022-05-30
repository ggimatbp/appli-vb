<?php

namespace App\Repository;

use App\Entity\ApCatalogVbBulkImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogVbBulkImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogVbBulkImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogVbBulkImage[]    findAll()
 * @method ApCatalogVbBulkImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogVbBulkImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogVbBulkImage::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ApCatalogVbBulkImage $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(ApCatalogVbBulkImage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }



    public function findOneMiniature($caseId): ?ApCatalogVbBulkImage
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.caseIs = :case')
            ->setParameter('case', $caseId)
            ->andWhere('a.miniature = 1')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByCase($caseId): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.caseIs = :case')
            ->setParameter('case', $caseId)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return ApCatalogVbBulkImage[] Returns an array of ApCatalogVbBulkImage objects
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
    public function findOneBySomeField($value): ?ApCatalogVbBulkImage
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
