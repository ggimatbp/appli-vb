<?php

namespace App\Controller\Tabs\Catalog;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApCatalogCustomerBpRepository;
use App\Repository\ApCatalogModelBpRepository; 
use App\Repository\ApCatalogFilesBpRepository;

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
    public function index(ApCatalogModelBpRepository $apCatalogModelBpRepository, ApCatalogCustomerBpRepository $apCatalogCustomerBpRepository, ApCatalogFilesBpRepository $apCatalogFilesBpRepository): Response
    {
        return $this->render('tabs/catalog/index/index.html.twig',  [
            'ap_catalog_model_bps' => $apCatalogModelBpRepository->findAll(),
            'ap_catalog_customer_bps' => $apCatalogCustomerBpRepository->findAll(),
            'ap_catalog_files_bps' => $apCatalogFilesBpRepository->findAll(),
        ]);
    }
    #endregion function index
}
