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


    //$users = $userRepository->findAll();

    /**
     * @return User[] Returns an array of User objects
     */

    public function findUserByfilterField($ajaxActive = null, $ajaxRoleId = null, $ajaxEmail= null, $ajaxFirstname = null, $ajaxLastname = null, $ajaxId = null)
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

        return $query->getQuery()->getResult()
        ;
    }


    // /**
    // * @return User[] Returns an array of User objects
    // */
    // public function findUserByfilterField($active)
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT p
    //         FROM App\Entity\User u
    //         WHERE u.active = :active
    //         ORDER BY u.id ASC'
    //     )->setParameter('active', $active);

    //     // returns an array of Product objects
    //     return $query->getResult();
    // }


}
