<?php

namespace App\Repository;

use App\Entity\ApEmployee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApEmployee|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApEmployee|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApEmployee[]    findAll()
 * @method ApEmployee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApEmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApEmployee::class);
    }

    // /**
    //  * @return ApEmployee[] Returns an array of ApEmployee objects
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
    public function findOneBySomeField($value): ?ApEmployee
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
