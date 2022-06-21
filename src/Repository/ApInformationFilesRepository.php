<?php

namespace App\Repository;

use App\Entity\ApInformationFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApInformationFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApInformationFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApInformationFiles[]    findAll()
 * @method ApInformationFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApInformationFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApInformationFiles::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ApInformationFiles $entity, bool $flush = true): void
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
    public function remove(ApInformationFiles $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllInfoFilesBySector($id): array
    {
        return $this->createQueryBuilder('a')
        ->andWhere('a.Section = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findRecentRhFiles(): array
    {
        return $this->createQueryBuilder('a')
        ->join('a.Section', 'b')
        ->where('b.state = 1')
        ->andWhere('date_diff( CURRENT_DATE() , a.createdAt) < 7')
        ->orderBy('a.createdAt', 'desc')
        ->getQuery()
        ->getResult()
        ;
    }

    public function findRecentQseFiles(): array
    {
        return $this->createQueryBuilder('a')
        ->join('a.Section', 'b')
        ->where('b.state = 2')
        ->andWhere('date_diff( CURRENT_DATE() , a.createdAt) < 7')
        ->orderBy('a.createdAt', 'desc')
        ->getQuery()
        ->getResult()
        ;
    }


    public function findLastRhFiles()
    {
        return $this->createQueryBuilder('a')
        ->join('a.Section', 'b')
        ->where('b.state = 1')
        ->orderBy('a.createdAt', 'desc')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        ;
    }

    public function findLastQseFiles()
    {
        return $this->createQueryBuilder('a')
        ->join('a.Section', 'b')
        ->where('b.state = 2')
        ->orderBy('a.createdAt', 'desc')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult()
        ;
    }

    public function findAllFilesByUserView($user)
    {
        return $this->createQueryBuilder('a')
        ->join('a.apInformationVieweds', 'b')
        ->where('b.user = :user')
        ->setParameter('user', $user)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return ApInformationFiles[] Returns an array of ApInformationFiles objects
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
    public function findOneBySomeField($value): ?ApInformationFiles
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
