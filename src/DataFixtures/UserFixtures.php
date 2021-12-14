<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use app\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
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
    $contributor->setTheme(0);
    $contributor->setPassword($this->passwordHasher->hashPassword(
        $contributor,
        '123'
    ));
    $contributor->setRoles($this->getReference('Role_1')->name);
    $contributor->setFirstname("Michel");
    $contributor->setLastname("Plaqueminier");
    $contributor->setActive(1);
    $manager->persist($contributor);

    // Création d’un utilisateur de type “administrateur”
    $admin = new User();
    $admin->setEmail('admin@monsite.com');
    $admin->setRoleId($this->getReference('Role_2'));
    $admin->setTheme(0);
    $admin->setPassword($this->passwordHasher->hashPassword(
        $admin,
        '123'
    ));
    $admin->setFirstname("anita");
    $admin->setLastname("jesusdasilva");
    $admin->setActive(1);
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
