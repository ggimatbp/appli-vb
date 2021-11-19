<?php

namespace App\Controller\Tabs\Catalog;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/catalog", name="catalog_")
 */

class CatalogController extends AbstractController
{	
    #region function index
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('catalog/index.html.twig', compact('ap_accesses','ap_roles', 'users', 'total', 'limit', 'page', 'session', 'filterSession', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession', 'allRole'));
    }

}