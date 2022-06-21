<?php

namespace App\Repository;

use App\Entity\ApInformationSignature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApInformationSignature|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApInformationSignature|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApInformationSignature[]    findAll()
 * @method ApInformationSignature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApInformationSignatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApInformationSignature::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ApInformationSignature $entity, bool $flush = true): void
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
    public function remove(ApInformationSignature $entity, bool $flush = true): void
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
            ->getOneOrNullResult()
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
    //  * @return ApInformationSignature[] Returns an array of ApInformationSignature objects
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
    public function findOneBySomeField($value): ?ApInformationSignature
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
