<?php

namespace App\Repository;

use App\Entity\PsAdress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PsAdress|null find($id, $lockMode = null, $lockVersion = null)
 * @method PsAdress|null findOneBy(array $criteria, array $orderBy = null)
 * @method PsAdress[]    findAll()
 * @method PsAdress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PsAdressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PsAdress::class);
    }

    // /**
    //  * @return PsAdress[] Returns an array of PsAdress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PsAdress
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
