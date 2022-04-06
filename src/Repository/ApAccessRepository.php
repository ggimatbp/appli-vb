<?php

namespace App\Repository;

use App\Entity\ApAccess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApAccess|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApAccess|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApAccess[]    findAll()
 * @method ApAccess[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApAccessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApAccess::class);
    }

    // /**
    //  * @return ApAccess[] Returns an array of ApAccess objects
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
            ->getResult    // public function getTabByRoleaccess($user)
    // {
    //     $queryBuilder = $this->createQueryBuilder('a')
    //         ->where( 'a.role!= :role' );
    //         // ->orderBy('t.id', 'ASC');
    //         // $er->andWhere($er->expr()->in('ap_access.tab_id'));
    //     $queryBuilderComparaison = $this->createQueryBuilder('ta')
    //     ->leftJoin('ta.tab' , 't')
    //     ->where('t.id NOT IN (' . $queryBuilder->getDQL() . ')')
    //     ->setParameter('role', $user);
        
    //     return $queryBuilderComparaison->getQuery()->getResult();
 
    // }()
        ;
    }
    */



}
