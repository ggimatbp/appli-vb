<?php

namespace App\Controller\Tabs\Catalog\VB;

use App\Entity\ApSectorVb;
use App\Form\ApSectorVbType;
use App\Repository\ApCatalogCaseVbRepository;
use App\Repository\ApSectorVbRepository;
use App\Repository\ApCatalogFilesVbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GlobalHistoryService;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/ap/sector/vb")
 */
class ApSectorVbController extends AbstractController
{

    #region constant
    const TAB_VB = "Velobatterie";
    #endregion

    /**
     * @Route("/", name="ap_sector_vb_index", methods={"GET"})
     */
    public function index(ApSectorVbRepository $apSectorVbRepository): Response
    {
        return $this->render('tabs/Catalog/VB/ap_sector_vb/index.html.twig', [
            'ap_sector_vbs' => $apSectorVbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="ap_sector_vb_new", methods={"GET","POST"})
     */
    public function new(Request $request, ApCatalogCaseVbRepository $apCatalogCaseVbRepository, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $tabName = self::TAB_VB;
        $apSectorVb = new ApSectorVb();
        $caseId = intval(basename("$_SERVER[REQUEST_URI]"));
        $form = $this->createForm(ApSectorVbType::class, $apSectorVb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $case = $apCatalogCaseVbRepository->find($caseId);
            $apSectorVb->setCaseId($case);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apSectorVb);
            $entityManager->flush();
            $GlobalHistoryService->setInHistory($apSectorVb, 'new');

            return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $caseId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_sector_vb/new.html.twig', [
            'ap_sector_vb' => $apSectorVb,
            'form' => $form,
            'tabName' => $tabName,
            'case_id' => $caseId
        ]);
    }

    /**
     * @Route("/{id}", name="ap_sector_vb_show", methods={"GET"})
     */
    public function show(ApSectorVb $apSectorVb, ApCatalogFilesVbRepository $apCatalogFilesVbRepository): Response
    {
        $tabName = self::TAB_VB;
        $id = $apSectorVb->getId();
        $files = $apCatalogFilesVbRepository->findFilesBySectors($id);
        // $sectorId = intval(basename("$_SERVER[REQUEST_URI]"));
        // $apCatalogCaseVbRepository->find($sectorId);
        return $this->render('tabs/Catalog/VB/ap_sector_vb/show.html.twig', [
            'files' => $files,
            'ap_sector_vb' => $apSectorVb,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_sector_vb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApSectorVb $apSectorVb, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $tabName = self::TAB_VB;
        $form = $this->createForm(ApSectorVbType::class, $apSectorVb);
        $form->handleRequest($request);
        $sectorId = $apSectorVb->getId();
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $GlobalHistoryService->setInHistory($apSectorVb, 'edit');
            return $this->redirectToRoute('ap_sector_vb_show', ['id' => $sectorId ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_sector_vb/edit.html.twig', [
            'ap_sector_vb' => $apSectorVb,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}", name="ap_sector_vb_delete", methods={"POST"})
     */
    public function delete(Request $request, ApSectorVb $apSectorVb, GlobalHistoryService $GlobalHistoryService, ApCatalogFilesVbRepository $files, ManagerRegistry $doctrine): Response
    {
       $case = $apSectorVb->getCaseId();
       $caseId = $case->getId();
       $sectorId = $apSectorVb->getId();
       $allFilesInSector = $files->findFilesBySectors($sectorId);
        if ($this->isCsrfTokenValid('delete'.$apSectorVb->getId(), $request->request->get('_token'))) {
            if($allFilesInSector == NULL){
                $GlobalHistoryService->setInHistory($apSectorVb, 'delete');
                $entityManager = $doctrine->getManager();
                $entityManager->remove($apSectorVb);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $caseId], Response::HTTP_SEE_OTHER);
    }

    /**
     *  @Route("/archive/{id}", name="ap_sector_vb_archive", methods={"GET","POST"})
     */
    public function archive(ApCatalogFilesVbRepository $files, Request  $request, GlobalHistoryService $GlobalHistoryService, ApSectorVb $apSectorVb, ManagerRegistry $doctrine): Response
    {   
        $sectorId = $apSectorVb->getId();
        $allFilesInSector = $files->findFilesBySectors($sectorId);
        if ($this->isCsrfTokenValid('archiver'. $sectorId, $request->request->get('_token')))
        {
            if($apSectorVb->getArchive() == 0)
            {
                $GlobalHistoryService->setInHistory($apSectorVb, 'Archive');
                $apSectorVb->setArchive(1);
                foreach($allFilesInSector as $file){
                    if ($file->getArchive() == 0 ){
                        $file->setArchive(1);
                        $GlobalHistoryService->setInHistory($file, 'Archive');
                        $entityManager = $doctrine->getManager();
                        $entityManager->persist($file);
                        $entityManager->flush();
                    }
                }
            }else{
                $GlobalHistoryService->setInHistory($apSectorVb, 'Unarchive');
                $apSectorVb->setArchive(0);
            }
                $entityManager = $doctrine->getManager();
                $entityManager->persist($apSectorVb);
                $entityManager->flush();
        }
        return $this->redirectToRoute('ap_sector_vb_show', ['id' => $sectorId], Response::HTTP_SEE_OTHER);
    }
}
