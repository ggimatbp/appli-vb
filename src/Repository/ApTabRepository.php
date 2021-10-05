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


    public function findAllId()
    {
        return $this->createQueryBuilder('a')
            ->select(`a.id`)
            ->getQuery()
            ->getResult();
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
    // public function getTabByRole($user)
    // {
    //     $em = $this->getEntityManager();
    //     return $query = $em->createQuery(
    //         'SELECT * FROM `ap_tab` WHERE `ap_tab`.id  NOT IN (SELECT ap_access.tab_id FROM ap_access WHERE ap_access.role_id = 18)'

    //     );
    // }
    
    // public function getTabByRole($user)
    // {
    //     $queryBuilder = $this->createQueryBuilder('t')

    //         ->leftJoin('t.apAccesses', 'a','WITH', 't.id = a.tab')
    //         ->where( 'a.role = :role' );
    //         // ->orderBy('t.id', 'ASC');
    //         // $er->andWhere($er->expr()->in('ap_access.tab_id'));
    //     $queryBuilderComparaison = $this->createQueryBuilder('ta')
    //     ->where('ta.id' . ' not in (' . $queryBuilder->getDQL() . ')')
    //     // ->where($queryBuilderComparaison->expr()->notIn($queryBuilder));
    //     ->setParameter('role', $user);
        
    //     return $queryBuilderComparaison;
 
    // }
    
    
}
