<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApSectorBp;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ApSectorBpFixture extends Fixture implements DependentFixtureInterface
{

    public const TABLES = [
        'Pack',
        'BMS',
        'Produit fini',
        'Cable',
        'Poinçonnage'
    ];

    public function load(ObjectManager $manager)
    {   
        $tablesIndex = 0;
        foreach (self::TABLES as $val)
        {
            $tablesIndex++;
            $sector = new ApSectorBp;
            $sector->setName($val);
            $sector->setModel($this->getReference('catalogModel_'. 2));
            $manager->persist($sector);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ApCatalogCustomerBpFixtures::class,
            ApCatalogModelBpFixtures::class,
            ];
    }
}
