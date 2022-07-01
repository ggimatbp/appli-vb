<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApTab;

class AppTabFixture extends Fixture
{
    // instruction Icons will not be generated please do not forget to add them directly inside the BDD
    public const TABLES = [
        [
            'name' => 'Management',
            'path' => 'manager_index',
            'controlpath' => 'Manager',
            'children' => [
                ['name' => 'Employé',
                'path' => 'tabs/manager/index/employee.html.twig',
                'controlpath' => 'User'],
                ['name' => 'Role',
                'path' => 'tabs/manager/index/roleAndAccess.html.twig',
                'controlpath' => 'Role']
            ],
        ],
        [
            'name' => 'Catalogue',
            'path' => 'catalog_index',
            'controlpath' => 'Catalog',
            'children' => [
                ['name' => 'Batteries-Prod',
                'path' => 'tabs/Catalog/index/batterieprod.html.twig',
                'controlpath' => 'Bp'],

                ['name' => 'Velobatterie',
                'path' => 'tabs/Catalog/index/velobatterie.html.twig',
                'controlpath' => 'Vb'],
            ],

        ],
        [
            'name' => 'Information',
            'path' => 'information_index',
            'controlpath' => 'Information',
            'children' => [
                [
                    'name' => 'RH',
                    'path' => 'information_rh_index',
                    'controlpath' => 'Rh'
                ],
                [
                    'name' => 'QSE',
                    'path' => 'information_qse_index',
                    'controlpath' => 'Qse'
                ],
                [
                    'name' => 'Perso',
                    'path' => 'information_perso_index',
                    'controlpath' => 'Perso'
                ],
            ]
        ],
        [
            'name' => 'Prises en charge BP',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                [
                    'name' => 'En cours',
                    'path' => 'manager_fake',
                    'controlpath' => 'spikabarou',
                ],
                [
                    'name' => 'Archivées',
                    'path' => 'manager_fake',
                    'controlpath' => 'spikabarou',
                ],
                [
                    'name' => 'Admin',
                    'path' => 'manager_fake',
                    'controlpath' => 'spikabarou',
                ]
            ]
        ],
        [
            'name' => 'Prises en Charges SAV',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                [
                    'name' => 'Vélobatterie',
                    'path' => 'manager_fake',
                    'controlpath' => 'spikabarou',
                ],
                [
                    'name' => 'Batteries-prod',
                    'path' => 'manager_fake',
                    'controlpath' => 'spikabarou',
                ],
            ]
        ],
        [
            'name' => 'Expedition',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                ['name' => 'En cours',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou',
            ],
                ['name' => 'Traité',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou',
            ],
            ]
        ],
        [
            'name' => 'Non-conformités',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                ['name' => 'En cours',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
                ['name' => 'Archivées',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
            ]
        ],
        [
            'name' => 'Pointage',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                ['name' => 'Mon pointage',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
                ['name' => 'Demande de congés',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
                ['name' => 'Admin',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou']
            ]
        ],
        [
            'name' => 'Informations',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                ['name' => 'Ressources humaines',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
                ['name' => 'Qualité et sécurité',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
            ]
        ],
        [
            'name' => 'Catalogue',
            'path' => 'manager_fake',
            'controlpath' => 'spikabarou',
            'children' => [
                ['name' => 'Batteries-prod',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
                ['name' => 'Velobatterie',
                'path' => 'manager_fake',
                'controlpath' => 'spikabarou'],
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
            $tab->setControlPath($val['controlpath']);
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
        $tabPosition = 0;
        foreach ($children as $child) {
            $tabIndex++;
            $tabPosition++;
            $tabChild = new ApTab();
            $tabChild->setName($child['name']);
            $tabChild->setPath($child['path']);
            $tabChild->setControlPath($child['controlpath']);
            $tabChild->setPosition($tabPosition);
            $tabChild->setAptab($tab);
            $manager->persist($tabChild);
            $this->addReference('tab_' . $tabIndex, $tabChild);
            if (isset($child['children'])) {
                $this->loadChildren($tabChild, $child['children'], $manager, $tabIndex);
            }
        }
    }
}
