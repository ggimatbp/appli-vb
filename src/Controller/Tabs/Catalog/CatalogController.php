<?php

namespace App\Controller\Tabs\Catalog;

use App\Repository\ApCatalogCaseVbRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApCatalogCustomerBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApCatalogFilesBpRepository;
use Symfony\Component\HttpFoundation\Request;
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
  public function index(ApCatalogModelBpRepository $apCatalogModelBpRepository, ApCatalogCustomerBpRepository $apCatalogCustomerBpRepository, ApCatalogFilesBpRepository $apCatalogFilesBpRepository, ApCatalogCaseVbRepository $apCatalogCaseVbRepository, Request $request): Response
  {
    $tabName = self::TAB_BP;
    $tabName2 = self::TAB_VB;

    //#region BP
    $errors = [];
    $errorsCustomer = [];
    if (isset($_POST['btnModelValue'])) {
      $modelId = $_POST['model-value'];
      if (empty($modelId)) {
        $errors["modelId"] = "invalide";
        // $roleback = 1;
      } elseif (count($errors) == 0) {

        return $this->redirectToRoute('ap_sector_bp_index', ['id' => $modelId]);
      }
    }
    if (isset($_POST['btnCustomerValue'])) {
      $customerId = $_POST['model-value'];
      if (empty($customerId)) {
        $errorsCustomer["customerId"] = "invalide";
      } elseif (count($errorsCustomer) == 0) {
        return $this->redirectToRoute('ap_catalog_customer_bp_show', ['id' => $customerId]);
      }
    }
    //#endregion 

    //#region VB
    $errorsPack = [];
    if (isset($_POST['btnPackValue'])) {
      $packId = $_POST['pack-value'];
      if (empty($packId)) {
        $errorsPack["packId"] = "invalide";
        // $roleback = 2;
        // return $this->redirectToRoute('catalog_index', ['roleback' => 2], Response::HTTP_SEE_OTHER);
        // return $this->render('tabs/catalog/index/index.html.twig',  [
        //  // BP
        //   'ap_catalog_model_bps' => $apCatalogModelBpRepository->findAll(),
        //   'ap_catalog_customer_bps' => $apCatalogCustomerBpRepository->findAll(),
        //   'ap_catalog_files_bps' => $apCatalogFilesBpRepository->findAll(),
        //   'errors' => $errors,
        //   'errorsCustomer' => $errorsCustomer,
        //   'tabName' => $tabName,
        //   //VB
        //   'ap_catalog_case_vbs' => $apCatalogCaseVbRepository->findAll(), 
        //   'tabName2' => $tabName2,
        //   'errorsPack' => $errorsPack,
        //   'roleback' => $roleback
        // ]);
      } elseif (count($errorsPack) == 0) {
        // var_dump($packId    );
        return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $packId]);
      }
    }
    // if(intval(basename("$_SERVER[REQUEST_URI]")) === 0 ){
    //   $errorsPack["packId"] = "invalide";
    // };
    // if($request->get('roleback=2&0=?45')){
    //   $errorsPack["packId"] = "invalide";
    // }
    // $montest = intval(basename("$_SERVER[REQUEST_URI]"));
    //#endregion

    return $this->render('tabs/Catalog/index/index.html.twig',  [
      //BP
      'ap_catalog_model_bps' => $apCatalogModelBpRepository->findAll(),
      'ap_catalog_customer_bps' => $apCatalogCustomerBpRepository->findAll(),
      'ap_catalog_files_bps' => $apCatalogFilesBpRepository->findAll(),
      'errors' => $errors,
      'errorsCustomer' => $errorsCustomer,
      'tabName' => $tabName,
      //VB
      'ap_catalog_case_vbs' => $apCatalogCaseVbRepository->findAll(),
      'tabName2' => $tabName2,
      'errorsPack' => $errorsPack,
    ]);
  }
  #endregion function index
}
