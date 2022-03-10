<?php

namespace App\Utility;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class DbProcessor {

    private $request;
    private $security;

    public function __construct(RequestStack $request, Security $security)
    {
        $this->request = $request->getCurrentRequest();
        $this->security = $security;
    }

    public function __invoke(array $record)
    {
        //on modifie le $record pour ajouter nos infos.
        $record['extra']['info']['route'] = $this->request->attributes->get('_route');
        $record['extra']['info']['controller'] = $this->request->attributes->get('_controller');
        $record['extra']['info']['objectId'] = $this->request->request->all();
        $user = $this->security->getUser();
        $record['extra']['user'] = $user;


        //
        // $classMeta = $em->getClassMetadata($className);
        // if ($classMeta->rootEntityName !== $className) {
        //     // if the Entity is inherited, only root entity table may have auto increment ID
        //     $classMeta = $em->getClassMetadata($classMeta->rootEntityName);
        // }
        // $tableName = $classMeta->getTableName();

        // $conn = $em->getConnection();
        // $stmt = $conn->prepare("SHOW TABLE STATUS LIKE '".$tableName."'");
        // $stmt->execute();
        // $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        // $id = $result['Auto_increment'];
        //
        return $record;
    }
}