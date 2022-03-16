<?php

namespace App\Repository;

use App\Entity\ApSectorBp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApSectorBp|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApSectorBp|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApSectorBp[]    findAll()
 * @method ApSectorBp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApSectorBpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApSectorBp::class);
    }

    // /**
    //  * @return ApSectorBp[] Returns an array of ApSectorBp objects
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
    public function findOneBySomeField($value): ?ApSectorBp
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSectionByModel($id): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.model = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    
}
