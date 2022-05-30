<?php

namespace App\Repository;

use App\Entity\ApInformationParapher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApInformationParapher|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApInformationParapher|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApInformationParapher[]    findAll()
 * @method ApInformationParapher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApInformationParapherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApInformationParapher::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ApInformationParapher $entity, bool $flush = true): void
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
    public function remove(ApInformationParapher $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function findByUserAndFile($user, $file)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.User = :userid')
            ->setParameter('userid', $user)
            ->andWhere('a.fileId = :fileId')
            ->setParameter('fileId', $file)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByFileAndState($file, $state)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.state = :state')
            ->setParameter('state', $state)
            ->andWhere('a.fileId = :fileId')
            ->setParameter('fileId', $file)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFile($file)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.fileId = :fileId')
            ->setParameter('fileId', $file)
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?ApInformationParapher
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
