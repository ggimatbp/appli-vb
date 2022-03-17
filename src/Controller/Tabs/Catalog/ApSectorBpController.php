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


/**
 * @Route("/ap/sector/bp")
 */
class ApSectorBpController extends AbstractController
{

    #region constant
    const TAB_BP = "Batteries-Prod";
    #endregion

    // /**
    //  * @Route("/", name="ap_sector_bp_index", methods={"GET"})
    //  */
    // public function indexSectionByModel(ApSectorBpRepository $apSectorBpRepository): Response
    // {
    //     return $this->render('ap_sector_bp/index.html.twig', [
    //         'ap_sector_bps' => $apSectorBpRepository->findSectionByModel($id),
    //     ]);
    // }


    /**
     * @Route("/new/{id}", name="ap_sector_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request, ApCatalogModelBpRepository $modelRepo, GlobalHistoryService $globalHistoryService): Response
    {
        $tabName = self::TAB_BP;
        $apSectorBp = new ApSectorBp();
        $form = $this->createForm(ApSectorBpType::class, $apSectorBp);
        $form->handleRequest($request);
        $modelId = intval(basename("$_SERVER[REQUEST_URI]"));
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $modelRepo->find($modelId); 
            $apSectorBp->setModel($model);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apSectorBp);
            $entityManager->flush(); 
            $globalHistoryService->setInHistory($apSectorBp, 'new');
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
    public function edit(Request $request, ApSectorBp $apSectorBp, GlobalHistoryService $globalHistoryService): Response
    {

        $tabName = self::TAB_BP;
        $form = $this->createForm(ApSectorBpType::class, $apSectorBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $globalHistoryService->setInHistory($apSectorBp, 'edit');
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
    public function delete(Request $request, ApSectorBp $apSectorBp, GlobalHistoryService $globalHistoryService, ApCatalogFilesBpRepository $files): Response
    {
        $model = $apSectorBp->getModel();
        $modelId = $model->getId();
        $sectorId = $apSectorBp->getId();
        $allFilesInSector = $files->findFilesBySectors($sectorId);

        if ($this->isCsrfTokenValid('delete'.$apSectorBp->getId(), $request->request->get('_token'))) {
            if( $allFilesInSector == NULL){
                $globalHistoryService->setInHistory($apSectorBp, 'delete');
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($apSectorBp);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('ap_sector_bp_index', ['id' => $modelId], Response::HTTP_SEE_OTHER);
    }


}
