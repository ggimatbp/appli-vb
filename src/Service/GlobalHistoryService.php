<?php 

namespace App\Service;

use App\Entity\ApGlobalHistory;
use Symfony\Component\Security\Core\Security;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class GlobalHistoryService
{

    private $security;
    private $userRepository;
    private $manager;

     public function __construct(Security $security, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
    }


    // function setInHistory($object, $action, $extra = null)
    function setInHistory($object, $action, $ipAdress , $extra = NULL)
    {

    $apGlobalHistory = new ApGlobalHistory;

      //$request = Request::createFromGlobals();
    //  $ipUser = $request->getClientIp();
    

    //entity name
    $className = $this->manager->getClassMetadata(get_class($object))->getName();
    $apGlobalHistory->setEntityName($className);
    
    //Ipadress
     $apGlobalHistory->setIpAdress($ipAdress);

     //ObjectId
     $apGlobalHistory->setObjectId($object->getId());

    // fake
    // $apGlobalHistory->setObjectId(1);

    //date
    $apGlobalHistory->setCreatedAt(new \DateTime());
    
    //userId
    $user = $this->security->getUser();
    $userId = $this->userRepository->find($user);
    $apGlobalHistory->setUserId($userId->getId());

    //action
    $apGlobalHistory->setAction($action);

    //fake

    // $apGlobalHistory->setAction('create');
    // dd($apGlobalHistory);
    //extra
    $apGlobalHistory->setExtra($extra);

    

         $this->manager->persist($apGlobalHistory);
         $this->manager->flush();
    
    }
}