<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApAccess;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ApAccessFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $tabIndex=0;
        //change $i max each time you advance in a new module project and change the tabs route name fixture
        for($i = 1; $i <=10 ; $i++){
            $tabIndex++;
            $access = new ApAccess();
            $access->setRole($this->getReference('Role_2'));
            $access->setTab($this->getReference('tab_' . $tabIndex));
            $access->setView(1);
            $access->setDelete(1);
            $access->setEdit(1);
            $access->setAdd(1);
            $manager->persist($access);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppRoleFixture::class,
            AppTabFixture::class,
            ];
    }
}
