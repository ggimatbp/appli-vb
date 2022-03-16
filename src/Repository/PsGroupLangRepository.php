<?php

namespace App\Repository;

use App\Entity\PsGroupLang;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PsGroupLang|null find($id, $lockMode = null, $lockVersion = null)
 * @method PsGroupLang|null findOneBy(array $criteria, array $orderBy = null)
 * @method PsGroupLang[]    findAll()
 * @method PsGroupLang[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PsGroupLangRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PsGroupLang::class);
    }

    // /**
    //  * @return PsGroupLang[] Returns an array of PsGroupLang objects
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
    public function findOneBySomeField($value): ?PsGroupLang
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
