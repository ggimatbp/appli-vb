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

  #region constant
    const TAB_BP = "Batteries-Prod";
    const TAB_VB = "Velobatterie";
  #endregion

    #region function index


    /**
     * @Route("/", name="index")
     */
    public function index(ApCatalogModelBpRepository $apCatalogModelBpRepository, ApCatalogCustomerBpRepository $apCatalogCustomerBpRepository, ApCatalogFilesBpRepository $apCatalogFilesBpRepository): Response
    {
        $tabName = self::TAB_BP;
        $errors = [];
        $errorsCustomer =[];
        if (isset($_POST['btnModelValue'])){
          $modelId = $_POST['model-value'];
          if(empty($modelId))
          {
              $errors["modelId"] = "invalide";
          }elseif(count($errors) == 0 ){
            var_dump($modelId);
            return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $modelId]);
          }
        }
        if (isset($_POST['btnCustomerValue'])){
          $customerId = $_POST['model-value'];
          if(empty($customerId)){
            $errorsCustomer["customerId"] = "invalide";
          }elseif(count($errorsCustomer) == 0){
            return $this->redirectToRoute('ap_catalog_customer_bp_show', ['id' => $customerId]);
          }
        }

        return $this->render('tabs/catalog/index/index.html.twig',  [
            'ap_catalog_model_bps' => $apCatalogModelBpRepository->findAll(),
            'ap_catalog_customer_bps' => $apCatalogCustomerBpRepository->findAll(),
            'ap_catalog_files_bps' => $apCatalogFilesBpRepository->findAll(),
            'errors' => $errors,
            'errorsCustomer' => $errorsCustomer,
            'tabName' => $tabName,
        ]);
    }
    #endregion function index
}
