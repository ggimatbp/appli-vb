<?php

namespace App\Repository;

use App\Entity\ApTab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApTab|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApTab|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApTab[]    findAll()
 * @method ApTab[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApTabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApTab::class);
    }

    // /**
    //  * @return ApTab[] Returns an array of ApTab objects
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
    public function findOneBySomeField($value): ?ApTab
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
