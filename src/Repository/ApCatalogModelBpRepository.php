<?php

namespace App\Repository;

use App\Entity\ApCatalogModelBp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApCatalogModelBp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApCatalogModelBp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApCatalogModelBp[]    findAll()
 * @method ApCatalogModelBp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApCatalogModelBpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApCatalogModelBp::class);
    }

    // /**
    //  * @return ApCatalogModelBp[] Returns an array of ApCatalogModelBp objects
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
    public function findOneBySomeField($value): ?ApCatalogModelBp
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
            ->andWhere('a.customer = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

}
