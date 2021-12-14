<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApCatalogCustomerBp;

class ApCatalogCustomerBpFixtures extends Fixture
{

    public const TABLES = [
        'Marius',
        'Pierre',
        'Mikaïl',
        'Jean',
        'Décathfake',
        'interfake',
        'GoFake',
        'Nikebike',
        'Fabrice',
    ];

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $tablesIndex = 0;
        foreach (self::TABLES as $val) {
        $tablesIndex++;
        $catalogCustomer = new ApCatalogCustomerBp;
        $catalogCustomer->setName($val);
        $catalogCustomer->setArchive(0);
        $this->addReference('catalogCustomer_' . $tablesIndex, $catalogCustomer);
        $manager->persist($catalogCustomer);
        }
        $manager->flush();
    }
}
