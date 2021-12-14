<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApCatalogModelBp;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ApCatalogModelBpFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $index = 0;
        for($i = 1; $i <=20 ; $i++)
        {  
            $index++;
            $model = new ApCatalogModelBp;
            $model->setCustomer($this->getReference('catalogCustomer_'. rand(1,9)));
            $model->setName('model'. $index);
            $model->setArchive(0);
            $manager->persist($model);
        }
            

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ApCatalogCustomerBpFixtures::class,
            ];
    }
}
