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
      //$ipUser = $request->getClientIp();
    
      if($object === "login failed")
      {
        $apGlobalHistory->setEntityName("SecurityController");
        $apGlobalHistory->setObjectId(0);
        $apGlobalHistory->setUserId(0);
        //action
        $apGlobalHistory->setAction($action);

      }elseif($object === "view"){
        $apGlobalHistory->setEntityName($action);
        $apGlobalHistory->setObjectId(0);
        //userId
        $user = $this->security->getUser();
        $userId = $this->userRepository->find($user);
        $apGlobalHistory->setUserId($userId->getId());

        //action
        $apGlobalHistory->setAction($object);

      }else{
    //entity name
    $className = $this->manager->getClassMetadata(get_class($object))->getName();
    $apGlobalHistory->setEntityName($className);

    //ObjectId
    $apGlobalHistory->setObjectId($object->getId());

             //userId
    $user = $this->security->getUser();
    $userId = $this->userRepository->find($user);
    $apGlobalHistory->setUserId($userId->getId());

        //action
        $apGlobalHistory->setAction($action);

      }

    
    //Ipadress
     $apGlobalHistory->setIpAdress($ipAdress);



    // fake
    // $apGlobalHistory->setObjectId(1);

    //date
    $apGlobalHistory->setCreatedAt(new \DateTime());
    




    //fake

    // $apGlobalHistory->setAction('create');
    // dd($apGlobalHistory);
    //extra
    $apGlobalHistory->setExtra($extra);

    

         $this->manager->persist($apGlobalHistory);
         $this->manager->flush();
    
    }
}