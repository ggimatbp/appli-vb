<?php

namespace App\DataFixtures;

use App\Entity\ApRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{

       private $passwordHasher;

        public function __construct(UserPasswordHasherInterface $passwordHasher)
        {
            $this->passwordHasher = $passwordHasher;
         }

    public function load(ObjectManager $manager)
    {
    // Création d’un utilisateur de type “contributeur” (= auteur)
    $contributor = new User();
    $contributor->setEmail('contributor@monsite.com');
    $contributor->setRoleId($this->getReference('Role_1'));
    $contributor->setPassword($this->passwordHasher->hashPassword(
        $contributor,
        '123'
    ));
    $contributor->setRoles($this->getReference('Role_1')->name);

    $manager->persist($contributor);

    // Création d’un utilisateur de type “administrateur”
    $admin = new User();
    $admin->setEmail('admin@monsite.com');
    $admin->setRoleId($this->getReference('Role_2'));
    $admin->setPassword($this->passwordHasher->hashPassword(
        $admin,
        '123'
    ));
    $admin->setRoles($this->getReference('Role_2')->name);
    $manager->persist($admin);

    // Sauvegarde des 2 nouveaux utilisateurs :
    $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            AppRoleFixture::class,
        );
    }
}
