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
    $contributor->setJsonRole($contributor->getName());

    $manager->persist($contributor);

    // Création d’un utilisateur de type “administrateur”
    $admin = new ApRole();
    $admin->setName('ADMIN');
    $admin->setJsonRole($admin->getName());
    $manager->persist($admin);

    // Sauvegarde des 2 nouveaux utilisateurs :
    $manager->flush();
    }
}
