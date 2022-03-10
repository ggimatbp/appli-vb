<?php

//Logger processor see log.php/dBProcessor.php/DbHandler.php/DoctrineSubcriber.php/monolog.yaml/service.yaml

// namespace App\Utility;

// use Symfony\Component\HttpFoundation\RequestStack;
// use Symfony\Component\Security\Core\Security;

// class DbProcessor {

//     private $request;
//     private $security;

//     public function __construct(RequestStack $request, Security $security)
//     {
//         $this->request = $request->getCurrentRequest();
//         $this->security = $security;
//     }

//     public function __invoke(array $record)
//     {
//         //on modifie le $record pour ajouter nos infos.
//         $record['extra']['info']['route'] = $this->request->attributes->get('_route');
//         $record['extra']['info']['controller'] = $this->request->attributes->get('_controller');
//         $record['extra']['info']['objectId'] = $this->request->request->all();
//         $user = $this->security->getUser();
//         $record['extra']['user'] = $user;


//         return $record;
//     }
//}