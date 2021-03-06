<?php

namespace App\Repository;

use App\Entity\ApGlobalHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @method ApGlobalHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApGlobalHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApGlobalHistory[]    findAll()
 * @method ApGlobalHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApGlobalHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApGlobalHistory::class);
    }


    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ApGlobalHistory $entity, bool $flush = true): void
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
    public function remove(ApGlobalHistory $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ApGlobalHistory[] Returns an array of ApGlobalHistory objects
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
    public function findOneBySomeField($value): ?ApGlobalHistory
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
