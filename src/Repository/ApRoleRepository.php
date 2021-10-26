<?php

namespace App\Repository;

use App\Entity\ApRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApRole[]    findAll()
 * @method ApRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApRole::class);
    }

    // /**
    //  * @return ApRole[] Returns an array of ApRole objects
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

    
    public function findOneBySomeField($value): ?ApRole
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return ApRole[] Returns an array of Role objects
     */
    

     public function findRoleByFilterField($limit, $pages, $ajaxFilterRoleName = null, $ajaxRoleOrder = null)
     {
        $query = $this->createQueryBuilder('r');
            //order by name
        if($ajaxFilterRoleName != null){
            $query->andWhere('r.name LIKE :name')
            ->setParameter('name', '%' . $ajaxFilterRoleName . '%');
        }

            //orderby

        if($ajaxRoleOrder != null){
            if($ajaxRoleOrder == 1)
            {
                $query->orderBy('r.name', 'ASC');

            }elseif($ajaxRoleOrder == 0){

                $query->orderBy('r.name', 'DESC');

            }
        }

        $query->setFirstResult(($pages * $limit) - $limit)
        ->setMaxresults($limit);

        return $query->getQuery()->getResult();
     }

     /**
      * return all roles after filter
      */

      public function getTotalRoleAfterFilter($ajaxFilterRoleName = null, $ajaxRoleOrder = null)
      {
        $query = $this->createQueryBuilder('r');
            //order by name
        if($ajaxFilterRoleName != null){
            $query->andWhere('r.name LIKE :name')
            ->setParameter('name', '%' . $ajaxFilterRoleName . '%');
        }

            //orderby

        if($ajaxRoleOrder != null){
            if($ajaxRoleOrder == 1)
            {
                $query->orderBy('r.name', 'ASC');

            }elseif($ajaxRoleOrder == 0){

                $query->orderBy('r.name', 'DESC');

            }
        }

        $query->select('COUNT(r)');

        return $query->getQuery()->getSingleScalarResult();
     }
}
