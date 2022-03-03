<?php

namespace App\Controller\Tabs\Catalog\VB;

use App\Entity\ApCatalogFilesVb;
use App\Form\ApCatalogFilesVbType;
use App\Repository\ApCatalogFilesVbRepository;
use App\Repository\ApSectorVbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/catalog/files/vb")
 */
class ApCatalogFilesVbController extends AbstractController
{

    #region constant
    const TAB_VB = "Velobatterie";
    #endregion

    /**
     * @Route("/", name="ap_catalog_files_vb_index", methods={"GET"})
     */
    public function index(ApCatalogFilesVbRepository $apCatalogFilesVbRepository): Response
    {
        return $this->render('ap_catalog_files_vb/index.html.twig', [
            'ap_catalog_files_vbs' => $apCatalogFilesVbRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="ap_catalog_files_vb_new", methods={"GET","POST"})
     */
    public function new(Request $request, ApSectorVbRepository $ApSectorVbRepository): Response
    {
        $tabName = self::TAB_VB;
        $sectorId = intval(basename("$_SERVER[REQUEST_URI]"));
        $apCatalogFilesVb = new ApCatalogFilesVb();
        $form = $this->createForm(ApCatalogFilesVbType::class, $apCatalogFilesVb);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $sector = $ApSectorVbRepository->find($sectorId);
            $case = $sector->getCaseId();
            $imgFile = $apCatalogFilesVb->getImageFile();
            $fileExtension =  $imgFile->guessExtension();

            $apCatalogFilesVb->setCaseId($case);
            $apCatalogFilesVb->setSector($sector);
            $apCatalogFilesVb->setUser($this->getUser());
            $apCatalogFilesVb->setCreatedAt(new \DateTime());
            $apCatalogFilesVb->setFileSize(filesize($imgFile)/1024);
            $apCatalogFilesVb->setFileType($fileExtension);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogFilesVb);
            $entityManager->flush();
            return $this->redirectToRoute('ap_sector_vb_show', ['id' => $sectorId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_catalog_files_vb/new.html.twig', [
            'ap_catalog_files_vb' => $apCatalogFilesVb,
            'form' => $form,
            'sector_id' => $sectorId,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_files_vb_show", methods={"GET"})
     */
    public function show(ApCatalogFilesVb $apCatalogFilesVb): Response
    {
        $tabName = self::TAB_VB;
        return $this->render('tabs/Catalog/VB/ap_catalog_files_vb/show.html.twig', [
            'ap_catalog_files_vb' => $apCatalogFilesVb,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_files_vb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogFilesVb $apCatalogFilesVb): Response
    {
        $tabName = self::TAB_VB;
        $form = $this->createForm(ApCatalogFilesVbType::class, $apCatalogFilesVb);
        $form->handleRequest($request);
        $sector = $apCatalogFilesVb->getSector();
        $sectorId = $sector->getId();
        $fileBefore = $apCatalogFilesVb->getImageFile();

        if ($form->isSubmitted() && $form->isValid()) {
            $imgFile = $apCatalogFilesVb->getImageFile();
            if($imgFile == $fileBefore){ 
            }else{
                $fileExtension =  $imgFile->guessExtension();
                $apCatalogFilesVb->setFileType($fileExtension);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_sector_vb_show', ['id' => $sectorId ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_catalog_files_vb/edit.html.twig', [
            'ap_catalog_files_vb' => $apCatalogFilesVb,
            'form' => $form,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_files_vb_delete", methods={"POST"})
     */

    public function delete(Request $request, ApCatalogFilesVb $apCatalogFilesVb): Response
    {
        $sector = $apCatalogFilesVb->getSector();
        $sectorId = $sector->getId();

        if ($this->isCsrfTokenValid('delete'.$apCatalogFilesVb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogFilesVb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_sector_vb_show', ['id', $sectorId], Response::HTTP_SEE_OTHER);
    }
}
