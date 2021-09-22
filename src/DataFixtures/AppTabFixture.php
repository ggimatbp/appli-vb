<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApTab;

class AppTabFixture extends Fixture
{
    public const TABLES = [
        [
            'name' => 'Management',
            'path' => 'manager',
            'children' => [
                ['name' => 'employee',
                'path' => 'employee'],
                ['name' => 'role',
                'path' => 'roleAndAccess'],
            ]
        ],
        [
            'name' => 'Prise en Charge',
            'path' => 'manager1',
            'children' => [
                [
                    'name' => 'En cours',
                    'path' => 'manager'
                ],
                [
                    'name' => 'Archivées',
                    'path' => 'manager'
                ],
                [
                    'name' => 'Admin',
                    'path' => 'manager'
                ],
            ]
        ],
        [
            'name' => 'prises en charge BP',
            'path' => 'manager',
            'children' => [
                [
                    'name' => 'En cours',
                    'path' => 'manager'
                ],
                [
                    'name' => 'Archivées',
                    'path' => 'manager'
                ],
                [
                    'name' => 'Admin',
                    'path' => 'manager'
                ]
            ]
        ],
        [
            'name' => 'Prises en Charges SAV',
            'path' => 'manager',
            'children' => [
                [
                    'name' => 'Vélobatterie',
                    'path' => 'manager'
                ],
                [
                    'name' => 'Batteries-prod',
                    'path' => 'manager'
                ],
            ]
        ],
        [
            'name' => 'Expedition',
            'path' => 'manager',
            'children' => [
                ['name' => 'en cours',
                'path' => 'manager'
            ],
                ['name' => 'Traité',
                'path' => 'manager'
            ],
            ]
        ],
        [
            'name' => 'Non-conformités',
            'path' => 'manager',
            'children' => [
                ['name' => 'en cours',
                'path' => 'manager'],
                ['name' => 'Archivées',
                'path' => 'manager'],
            ]
        ],
        [
            'name' => 'Pointage',
            'path' => 'manager',
            'children' => [
                ['name' => 'Mon pointage',
                'path' => 'manager'],
                ['name' => 'Demande de congés',
                'path' => 'manager'],
                ['name' => 'Admin',
                'path' => 'manager']
            ]
        ],
        [
            'name' => 'Informations',
            'path' => 'manager',
            'children' => [
                ['name' => 'Ressources humaines',
                'path' => 'manager'],
                ['name' => 'Qualité et sécurité',
                'path' => 'manager'],
            ]
        ],
        [
            'name' => 'Catalogue',
            'path' => 'manager',
            'children' => [
                ['name' => 'Batteries-prod',
                'path' => 'manager'],
                ['name' => 'velobatterie',
                'path' => 'manager'],
            ]
        ],

    ];

    public function load(ObjectManager $manager)
    {
        // // création d'une tab parent
        // $management = new ApTab();
        // $management->setName("Management");
        // $management->setPath("manager");

        // $manager->persist($management);

        // $this->addReference('Tab_' . 1 , $management);

        // // Création d'une tab enfant employee

        // $employee = new ApTab();
        // $employee->setName("Employee");
        // $employee->setPath("home");
        // $employee->setApTab($this->getReference('Tab_1'));
        // $manager->persist($employee);

        // // Création d'une tab enfant Rôle

        // $manager->flush();

        // Génération des catégories mères
        $tabIndex = 0;
        foreach (self::TABLES as $val) {
            $tabIndex++;
            $tab = new ApTab();
            $tab->setName($val['name']);
            $tab->setPath($val['path']);
            $manager->persist($tab);
            $this->addReference('tab_' . $tabIndex, $tab);
            if (isset($val['children'])) {
                $this->loadChildren($tab, $val['children'], $manager, $tabIndex);
            }
        }
        $manager->flush();
    }

    private function loadChildren($tab, $children, $manager, &$tabIndex)
    {

        foreach ($children as $child) {
            $tabIndex++;
            $tabChild = new ApTab();
            $tabChild->setName($child['name']);
            $tabChild->setPath($child['path']);
            $tabChild->setAptab($tab);
            $manager->persist($tabChild);
            $this->addReference('tab_' . $tabIndex, $tabChild);
            if (isset($child['children'])) {
                $this->loadChildren($tabChild, $child['children'], $manager, $tabIndex);
            }
        }
    }
}
