<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    // public function findOneBySomeField($value): ?User
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

#region find user by filter
    /**
     * @return User[] Returns an array of User objects
     */

    public function findUserByfilterField($limit, $pages, $ajaxActive = null, $ajaxRoleId = null, $ajaxEmail= null, $ajaxFirstname = null, $ajaxLastname = null, $ajaxId = null, $ajaxOrder = null, $ajaxFilterNameOrder = null)
    {
        $query =  $this->createQueryBuilder('u');
        #region filter
        if($ajaxActive != null){
            $query->andWhere('u.active = :active')
            ->setParameter('active', $ajaxActive);
        }

        if($ajaxRoleId != null){
        $query->andwhere('u.roleId = :roleid')
             ->setParameter('roleid', $ajaxRoleId);
        }

        if($ajaxEmail != null){
        $query->andwhere('u.email LIKE :email')
        ->setParameter('email', '%'. $ajaxEmail .'%');
        }

        if($ajaxFirstname != null){
            $query->andwhere('u.firstname LIKE :firstname')
            ->setParameter('firstname', '%'. $ajaxFirstname .'%');
            }

        if($ajaxLastname != null){
                $query->andwhere('u.lastname LIKE :lastname')
                ->setParameter('lastname', '%'. $ajaxLastname .'%');
            }

        if($ajaxId != null){
            $query->andwhere('u.id LIKE :id')
            ->setParameter('id', '%'. $ajaxId .'%');
        }
        #endregion filter
        #region order
        if($ajaxOrder != null){
            $ajaxOrder == 1 ? $orderBy = 'ASC' : $orderBy = 'DESC';
            // {
            //     $orderBy = 'ASC';

            if($ajaxFilterNameOrder == "role"){
                $query->leftJoin('u.roleId', 'r')
                ->orderBy('r.name',  $orderBy);
            }elseif(isset($ajaxFilterNameOrder))
                {
                    $query->orderBy('u.' . $ajaxFilterNameOrder, $orderBy);
                }
                // if($ajaxFilterNameOrder == "email"){
                //     $query->orderBy('u.email', 'ASC');
                // }
                // if($ajaxFilterNameOrder == "firstname"){
                //     $query->orderBy('u.firstname', 'ASC');
                // }
                // if($ajaxFilterNameOrder == "lastname"){
                //     $query->orderBy('u.lastname', 'ASC');
                // }
                // if($ajaxFilterNameOrder == "id"){
                //     $query->orderBy('u.id', 'ASC');
                // }

                
            // }elseif($ajaxOrder == 0){
            //     if(isset($ajaxFilterNameOrder)){
            //         $query->orderBy('u.' . $ajaxFilterNameOrder, 'DESC');
            //     }
            //     // if($ajaxFilterNameOrder == "email"){
            //     //     $query->orderBy('u.email', 'DESC');
            //     // }
            //     // if($ajaxFilterNameOrder == "firstname"){
            //     //     $query->orderBy('u.firstname', 'DESC');
            //     // }
            //     // if($ajaxFilterNameOrder == "lastname"){
            //     //     $query->orderBy('u.lastname', 'DESC');
            //     // }
            //     // if($ajaxFilterNameOrder == "id"){
            //     //     $query->orderBy('u.id', 'DESC');
            //     // }
            //     if($ajaxFilterNameOrder == "role"){
            //         $query->leftJoin('u.roleId', 'r')
            //         ->orderBy('r.name', 'DESC');
            //     }
            // }
        }
        #endregion order
            $query->setFirstResult(($pages * $limit) - $limit)
            ->setMaxresults($limit);

        return $query->getQuery()->getResult();
    }
#endregion find user by filter

#region find user in one page
//On récupére les employés en fonction de la pages et de la limite 
    /**
     * Returns all user per page
     * @return void
    */

    public function getPaginatedUsers($pages, $limit){
        $query = $this->createQueryBuilder('u')
        ->setFirstResult(($pages * $limit) - $limit)
        ->setMaxresults($limit);
        return $query->getQuery()->getResult();
    }
#endregion find user in one page

#region total number of user

    public function getTotalUsers(){
        $query = $this->createQueryBuilder('u')
        ->select('COUNT(u)');
        

        return $query->getQuery()->getSingleScalarResult();
    }
#endregion total user

#region total user after filters

    public function getTotalUsersAfterFilters($ajaxActive = null, $ajaxRoleId = null, $ajaxEmail= null, $ajaxFirstname = null, $ajaxLastname = null, $ajaxId = null)
    {
        $query =  $this->createQueryBuilder('u');
        if($ajaxActive != null){
            $query->andWhere('u.active = :active')
            ->setParameter('active', $ajaxActive);
        }

        if($ajaxRoleId != null){
        $query->andwhere('u.roleId = :roleid')
             ->setParameter('roleid', $ajaxRoleId);
        }

        if($ajaxEmail != null){
        $query->andwhere('u.email LIKE :email')
        ->setParameter('email', '%'. $ajaxEmail .'%');
        }

        if($ajaxFirstname != null){
            $query->andwhere('u.firstname LIKE :firstname')
            ->setParameter('firstname', '%'. $ajaxFirstname .'%');
            }

        if($ajaxLastname != null){
                $query->andwhere('u.lastname LIKE :lastname')
                ->setParameter('lastname', '%'. $ajaxLastname .'%');
            }

        if($ajaxId != null){
            $query->andwhere('u.id LIKE :id')
            ->setParameter('id', '%'. $ajaxId .'%');
        }

            $query->select('COUNT(u)');

            return $query->getQuery()->getSingleScalarResult();
    }
#endregion total user after filters

#region user by role
    public function getUsersByRole($role)
    {
        $query =  $this->createQueryBuilder('u');
        $query->andwhere('u.roleId = :roleid')
        ->setParameter('roleid', $role);
        return $query->getQuery()->getResult();
    }
#endregion user by role
}