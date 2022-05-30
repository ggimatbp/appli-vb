<?php

namespace App\Controller\Tabs\Catalog\VB;

use App\Entity\ApCatalogCaseVb;
use App\Form\ApCatalogCaseVbType;
use App\Repository\ApCatalogCaseVbRepository;
use App\Repository\ApSectorVbRepository;
use App\Repository\ApCatalogFilesVbRepository;
use App\Repository\ApCatalogVbBulkImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\GlobalHistoryService;

/**
 * @Route("/ap/catalog/case/vb")
 */
class ApCatalogCaseVbController extends AbstractController
{
    #region constant
      const TAB_VB = "Velobatterie";
    #endregion

    /**
     * @Route("/", name="ap_catalog_case_vb_index", methods={"GET"})
     */
    public function index(ApCatalogCaseVbRepository $apCatalogCaseVbRepository): Response
    {
        return $this->render('tabs/Catalog/VB/ap_catalog_case_vb/google_chart.html.twig', [
            'ap_catalog_case_vbs' => $apCatalogCaseVbRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/new", name="ap_catalog_case_vb_new", methods={"GET","POST"})
     */
    public function new(Request $request, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $tabName = self::TAB_VB;
        $apCatalogCaseVb = new ApCatalogCaseVb();
        $form = $this->createForm(ApCatalogCaseVbType::class, $apCatalogCaseVb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogCaseVb);
            $entityManager->flush();
            $GlobalHistoryService->setInHistory($apCatalogCaseVb, 'new');

            return $this->redirectToRoute('catalog_index', ['roleback' => 2], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_catalog_case_vb/new.html.twig', [
            'ap_catalog_case_vb' => $apCatalogCaseVb,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_case_vb_show", methods={"GET"})
     */
    public function show(ApCatalogCaseVb $apCatalogCaseVb, ApSectorVbRepository $apSectorVbRepository, ApCatalogVbBulkImageRepository $bulkImageRepository): Response
    {
        $tabName = self::TAB_VB;
        $id = $apCatalogCaseVb->getId();
        $apSectorVbs = $apSectorVbRepository->findSectionByCase($id);
        $bulkImage = $bulkImageRepository->findByCase($id);
        return $this->render('tabs/Catalog/VB/ap_catalog_case_vb/show.html.twig', [
            'ap_catalog_case_vb' => $apCatalogCaseVb,
            'tabName' => $tabName,
            'ap_sector_vbs' => $apSectorVbs,
            'files' => $bulkImage
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_case_vb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogCaseVb $apCatalogCaseVb, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $tabName = self::TAB_VB;
        $form = $this->createForm(ApCatalogCaseVbType::class, $apCatalogCaseVb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $GlobalHistoryService->setInHistory($apCatalogCaseVb, 'edit');

            return $this->redirectToRoute('catalog_index', ['roleback' => 2], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_catalog_case_vb/edit.html.twig', [
            'ap_catalog_case_vb' => $apCatalogCaseVb,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_case_vb_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogCaseVb $apCatalogCaseVb, GlobalHistoryService $GlobalHistoryService, ApSectorVbRepository $sector, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apCatalogCaseVb->getId(), $request->request->get('_token'))) {
            $caseId = $apCatalogCaseVb->getId();
            $allFilesByCaseId = $sector->findSectionByCase($caseId);
            if($allFilesByCaseId == NULL){
                $GlobalHistoryService->setInHistory($apCatalogCaseVb, 'delete');   
                $entityManager = $doctrine->getManager();
                $entityManager->remove($apCatalogCaseVb);
                $entityManager->flush();
            }  
        }

        return $this->redirectToRoute('catalog_index', ['roleback' => 2], Response::HTTP_SEE_OTHER);
    }

    /**
     *@Route("/archive/{id}", name="ap_catalog_case_vb_archive", methods={"GET","POST"})
     */
    public function archive(ApCatalogCaseVb $apCatalogCaseVb, ApCatalogFilesVbRepository $apCatalogFilesVbRepository, Request $request, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('archiver' . $apCatalogCaseVb->getId(), $request->request->get('_token')))
        {
            if ($apCatalogCaseVb->getArchive() == 0) {
                $apCatalogCaseVb->setArchive(1);
                $caseId = $apCatalogCaseVb->getId();
                $allFilesByCaseId = $apCatalogFilesVbRepository->findAllFileByCaseId($caseId);
                $GlobalHistoryService->setInHistory($apCatalogCaseVb, 'archive parent');   
                foreach ($allFilesByCaseId as $file) {
                    $file->setArchive(1);
                    $GlobalHistoryService->setInHistory($file, 'archive children');   
                }
            } else {
                $apCatalogCaseVb->setArchive(0);
                $caseId = $apCatalogCaseVb->getId();
                $allFilesByCaseId = $apCatalogFilesVbRepository->findAllFileByCaseId($caseId);
                $GlobalHistoryService->setInHistory($apCatalogCaseVb, 'archive parent');
                foreach ($allFilesByCaseId as $file) {
                    $file->setArchive(0);
                    $GlobalHistoryService->setInHistory($file, 'archive children');
                }
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogCaseVb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('catalog_index', ['roleback' => 2], Response::HTTP_SEE_OTHER);
    }

    

}
