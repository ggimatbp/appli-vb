<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApRole;

class AppRoleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
    // Création d’un utilisateur de type “contributeur” (= auteur)
    $contributor = new ApRole();
    $contributor->setName("CONTRIBUTOR");
        

    $manager->persist($contributor);
    $this->addReference('Role_' . 1 , $contributor);

    // Création d’un utilisateur de type “administrateur”
    $admin = new ApRole();
    $admin->setName('ADMIN');
    $manager->persist($admin);
    $this->addReference('Role_' . 2 , $admin);
    
    // Sauvegarde des 2 nouveaux utilisateurs :
    $manager->flush();
    }
}


/*
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($apRole);
                $allTabs = $apTabRepository->findAllId(); 
                    foreach($allTabs as $tab){
                        $apAccess = new ApAccess;
                        $apAccess->setTab($tab);
                        $apAccess->setRole($apRole);
                        $apAccess->setView(0);
                        $apAccess->setAdd(0);
                        $apAccess->setEdit(0);
                        $apAccess->setDelete(0);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($apAccess);
                    };

                    $entityManager->flush();
                    $id = $apRole->getId();
*/

