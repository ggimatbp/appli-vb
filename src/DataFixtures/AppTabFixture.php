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
                ['name' => 'Employé',
                'path' => 'manager/employee.html.twig'],
                ['name' => 'Role',
                'path' => 'manager/roleAndAccess.html.twig'],
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
            'name' => 'Prises en charge BP',
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
                ['name' => 'En cours',
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
                ['name' => 'En cours',
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
                ['name' => 'Velobatterie',
                'path' => 'manager'],
            ]
        ],

    ];

    public function load(ObjectManager $manager)
    {

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
