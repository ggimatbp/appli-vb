<?php

namespace App\Repository;

use App\Entity\ApInformationViewed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApInformationViewed|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApInformationViewed|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApInformationViewed[]    findAll()
 * @method ApInformationViewed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApInformationViewedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApInformationViewed::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ApInformationViewed $entity, bool $flush = true): void
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
    public function remove(ApInformationViewed $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findByUserAndFile($user, $file)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user = :userid')
            ->setParameter('userid', $user)
            ->andWhere('a.file = :fileId')
            ->setParameter('fileId', $file)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFile($file)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.file = :fileId')
            ->setParameter('fileId', $file)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return ApInformationViewed[] Returns an array of ApInformationViewed objects
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
    public function findOneBySomeField($value): ?ApInformationViewed
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
