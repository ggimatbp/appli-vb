<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApSectorBp;
use App\Form\ApSectorBpType;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApSectorBpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GlobalHistoryService;
use App\Repository\ApCatalogFilesBpRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/ap/sector/bp")
 */
class ApSectorBpController extends AbstractController
{

    #region constant
    const TAB_BP = "Batteries-Prod";
    #endregion

    /**
     * @Route("/new/{id}", name="ap_sector_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request, ApCatalogModelBpRepository $modelRepo, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();
        $globalHistoryService->setInHistory('View', 'ap_sector_bp_new', $ipUser);
        $tabName = self::TAB_BP;
        $apSectorBp = new ApSectorBp();
        $form = $this->createForm(ApSectorBpType::class, $apSectorBp);
        $form->handleRequest($request);
        $modelId = intval(basename("$_SERVER[REQUEST_URI]"));
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $modelRepo->find($modelId);
            $apSectorBp->setModel($model);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apSectorBp);
            $entityManager->flush(); 
            $globalHistoryService->setInHistory($apSectorBp, 'new', $ipUser);
            return $this->redirectToRoute('ap_sector_bp_index', ['id' => $modelId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/ap_sector_bp/new.html.twig', [
            'ap_sector_bp' => $apSectorBp,
            'form' => $form,
            'tabName' => $tabName,
            'model_id' => $modelId
        ]);
    }

    /**
     * @Route("/{id}", name="ap_sector_bp_show", methods={"GET"})
     */
    public function show(ApSectorBp $apSectorBp): Response
    {
        $tabName = self::TAB_BP;
        return $this->render('ap_sector_bp/show.html.twig', [
            'ap_sector_bp' => $apSectorBp,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_sector_bp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApSectorBp $apSectorBp, GlobalHistoryService $globalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $globalHistoryService->setInHistory($apSectorBp, 'ViewEdit', $ipUser);

        $tabName = self::TAB_BP;
        $form = $this->createForm(ApSectorBpType::class, $apSectorBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $globalHistoryService->setInHistory($apSectorBp, 'edit', $ipUser);
            return $this->redirectToRoute('ap_catalog_model_bp_show', ['id'=> $apSectorBp->getid()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/ap_sector_bp/edit.html.twig', [
            'ap_sector_bp' => $apSectorBp,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}", name="ap_sector_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApSectorBp $apSectorBp, GlobalHistoryService $globalHistoryService, ApCatalogFilesBpRepository $files, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $model = $apSectorBp->getModel();
        $modelId = $model->getId();
        $sectorId = $apSectorBp->getId();
        $allFilesInSector = $files->findFilesBySectors($sectorId);

        if ($this->isCsrfTokenValid('delete'.$apSectorBp->getId(), $request->request->get('_token'))) {
            if( $allFilesInSector == NULL){
                $globalHistoryService->setInHistory($apSectorBp, 'delete', $ipUser);
                $entityManager = $doctrine->getManager();
                $entityManager->remove($apSectorBp);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('ap_sector_bp_index', ['id' => $modelId], Response::HTTP_SEE_OTHER);
    }


}
