<?php

namespace App\Controller\Tabs\Catalog;



use App\Entity\ApCatalogModelBp;
use App\Entity\ApSectorBp;
use App\Form\ApCatalogModelBpType;
use App\Form\ApCatalogModelBpPreciseType;
use App\Repository\ApCatalogCustomerBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApCatalogFilesBpRepository;
use App\Repository\ApSectorBpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GlobalHistoryService;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @Route("/ap/catalog/model/bp")
 */
class ApCatalogModelBpController extends AbstractController
{
    #region constant
    const TAB_BP = "Batteries-Prod";
    #endregion

    // model show
    /**
     * @Route("/sectorByModel/{id}", name="ap_sector_bp_index", methods={"GET"})
     */
    public function indexSectionByModel(ApCatalogModelBp $apCatalogModelBp, ApSectorBpRepository $apSectorBpRepository, GlobalHistoryService $GlobalHistoryService): Response
    {
        $tabName = self::TAB_BP;

        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $GlobalHistoryService->setInHistory('view', 'ap_sector_bp_index', $ipUser);

        $id = $apCatalogModelBp->getId();
        return $this->render('tabs/Catalog/ap_catalog_model_bp/index_section.html.twig', [
            'ap_sector_bps' => $apSectorBpRepository->findSectionByModel($id),
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/new", name="ap_catalog_model_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $globalHistoryService->setInHistory('view', 'ap_catalog_model_bp_new', $ipUser);

        $tabName = self::TAB_BP;
        $apCatalogModelBp = new ApCatalogModelBp();
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager =  $doctrine->getManager();
            $entityManager->persist($apCatalogModelBp);
            $entityManager->flush();
            $globalHistoryService->setInHistory($apCatalogModelBp, 'new', $ipUser);
            return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/new.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/newPrecise/{id}", name="ap_catalog_model_bp_new_precise", methods={"GET","POST"})
     */
    public function newWithModel(Request $request, ApCatalogCustomerBpRepository $customerBpRepository, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $globalHistoryService->setInHistory('view', 'ap_catalog_model_bp_new_precise', $ipUser);
        $tabName = self::TAB_BP;
        $apCatalogModelBp = new ApCatalogModelBp();
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);
        $id = intval(basename("$_SERVER[REQUEST_URI]"));
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $customerBpRepository->find($id);
            $apCatalogModelBp->setCustomer($customer);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogModelBp);
            $entityManager->flush();
            $globalHistoryService->setInHistory($apCatalogModelBp, 'new', $ipUser , ['new with customer']);
            return $this->redirectToRoute('ap_catalog_customer_bp_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/new.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
            'id_customer' => $id,
            'tabName' => $tabName
        ]);
    }

    // Sector show
    /**
     * @Route("/{id}", name="ap_catalog_model_bp_show", methods={"GET"})
     */
    public function show(ApCatalogFilesBpRepository $ApCatalogFilesBpRepository, ApSectorBp $apSectorBp, GlobalHistoryService $globalHistoryService): Response
    {

        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $globalHistoryService->setInHistory('view', 'ap_catalog_model_bp_new_precise', $ipUser);

        $tabName = self::TAB_BP;
        $id = $apSectorBp->getId();
        $files = $ApCatalogFilesBpRepository->findFilesBySectors($id);
        return $this->render('tabs/Catalog/ap_catalog_model_bp/show.html.twig', [
            'files' => $files,
            'tabName' => $tabName,
            'ap_sector_bp' => $apSectorBp
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_model_bp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogModelBp $apCatalogModelBp, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $globalHistoryService->setInHistory($apCatalogModelBp, 'ViewEdit', $ipUser);

        $id = $apCatalogModelBp->getId();
        $tabName = self::TAB_BP;
        $form = $this->createForm(ApCatalogModelBppreciseType::class, $apCatalogModelBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $globalHistoryService->setInHistory($apCatalogModelBp, 'Edit', $ipUser);
            return $this->redirectToRoute('ap_sector_bp_index', ['id' =>  $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/edit.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/delete/{id}", name="ap_catalog_model_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogModelBp $apCatalogModelBp, ApCatalogModelBpRepository $modelRepository, GlobalHistoryService $globalHistoryService, ApSectorBpRepository $sectors, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

          $id = intval(basename("$_SERVER[REQUEST_URI]"));
          $model = $modelRepository->find($id);
          $customer = $model->getCustomer();
          $customerId = $customer->getId();
          $catalogId = $apCatalogModelBp->getId();
          $allSectorByModel = $sectors->findSectionByModel($catalogId);
        if ($this->isCsrfTokenValid('delete'.$apCatalogModelBp->getId(), $request->request->get('_token'))) {
            if($allSectorByModel == NULL){
                $globalHistoryService->setInHistory($apCatalogModelBp, 'delete', $ipUser);
                $entityManager = $doctrine->getManager();
                $entityManager->remove($apCatalogModelBp);
                $entityManager->flush();
            }
        }
         return $this->redirectToRoute('ap_catalog_customer_bp_show', ['id' => $customerId], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/pdf/{id}", name="pdf_js", methods={"GET"})
     */
    public function testPdfJs(ApCatalogModelBp $apCatalogModelBp, ApCatalogFilesBpRepository $ApCatalogFilesBpRepository): Response
    {
        
        $id = $apCatalogModelBp->getId();
        $files = $ApCatalogFilesBpRepository->findAllById($id);
        return $this->render('tabs/Catalog/ap_catalog_model_bp/Testshow.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp, 'files' => $files
        ]);
    }

    /**
     *@Route("/archive/{id}", name="ap_catalog_model_bp_archive", methods={"GET","POST"})
     */
    public function archive(ApCatalogModelBp $apCatalogModelBp, ApCatalogFilesBpRepository $apCatalogFilesBpRepository, Request  $request, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('archiver'.$apCatalogModelBp->getId(), $request->request->get('_token'))) {

            $request = Request::createFromGlobals();
            $ipUser = $request->getClientIp();

            if ($apCatalogModelBp->getArchive() == 0 ){
                $apCatalogModelBp->setArchive(1);
                $modelId = $apCatalogModelBp->getId();
                $globalHistoryService->setInHistory($apCatalogModelBp, 'archive', $ipUser);
                $filesbyModelId = $apCatalogFilesBpRepository->findAllById($modelId);
            foreach($filesbyModelId as $file){
                $globalHistoryService->setInHistory($file, 'children archive', $ipUser);
                $file->setArchive(1);
            }
            }else{
                $apCatalogModelBp->setArchive(0);
                $globalHistoryService->setInHistory($apCatalogModelBp, 'unarchive', $ipUser);
            }
            $customerId = $apCatalogModelBp->getCustomer()->getId();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogModelBp);
            $entityManager->flush();
            return $this->redirectToRoute('ap_catalog_customer_bp_show', ['id' => $customerId], Response::HTTP_SEE_OTHER);
            //   return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
     }
    }

    /**
     *@Route("/archive/sector/{id}", name="ap_catalog_model_bp_archive_section", methods={"GET","POST"})
     */

    public function archiveBySection(ApSectorBp $apSectorBp, ApSectorBpRepository $apSectorBpRepository, Request  $request, ApCatalogFilesBpRepository $ApCatalogFilesBpRepository, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine):response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $modelId = $apSectorBp->getModel()->getId();
        $sectorId = $apSectorBp->getId();
        if ($this->isCsrfTokenValid('archiver'.$apSectorBp->getId(), $request->request->get('_token'))) {
            if ($apSectorBp->getArchive() == 0 ){
                $apSectorBp->setArchive(1);
                $sectorId = $apSectorBp->getId();
                $modelId = $apSectorBp->getModel();
                $globalHistoryService->setInHistory($apSectorBp, 'archive', $ipUser);
                $filesbySectorId = $ApCatalogFilesBpRepository->findFilesBySectors($sectorId);
            foreach($filesbySectorId as $file){
                $file->setArchive(1);
                $globalHistoryService->setInHistory($file, 'children archive', $ipUser);
            }
            }else{
                $apSectorBp->setArchive(0);
                $globalHistoryService->setInHistory($apSectorBp, 'Unarchive', $ipUser);
            }
                $modelId = $apSectorBp->getModel()->getId();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($apSectorBp);
                $entityManager->flush();
            return $this->redirectToRoute('ap_sector_bp_index', ['id' => $modelId], Response::HTTP_SEE_OTHER);
        }
     return $this->redirectToRoute('ap_sector_bp_index', ['id' => $modelId], Response::HTTP_SEE_OTHER);
    }
}