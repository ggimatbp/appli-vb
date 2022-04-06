<?php

namespace App\Repository;

use App\Entity\ApSectorVb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApSectorVb|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApSectorVb|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApSectorVb[]    findAll()
 * @method ApSectorVb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApSectorVbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApSectorVb::class);
    }

    // /**
    //  * @return ApSectorVb[] Returns an array of ApSectorVb objects
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
    public function findOneBySomeField($value): ?ApSectorVb
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSectionByCase($id): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.caseId = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
}
