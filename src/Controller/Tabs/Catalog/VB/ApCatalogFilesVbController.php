<?php

namespace App\Controller\Tabs\Catalog\VB;

use App\Entity\ApCatalogFilesVb;
use App\Form\ApCatalogFilesVbType;
use App\Form\ApCatalogFilesVbEditType;
use App\Repository\ApCatalogFilesVbRepository;
use App\Repository\ApSectorVbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\GlobalHistoryService;
use App\Service\InterventionImage;


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
    public function new(InterventionImage $intervention, Request $request, ApSectorVbRepository $ApSectorVbRepository, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
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

            $width = getimagesize($imgFile)[0];
            $height = getimagesize($imgFile)[1];

            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogFilesVb);
            $entityManager->flush();
            if($fileExtension == "pdf"){}else{$intervention->resizeCatalogVbCarroussel($apCatalogFilesVb->getFileName(), $width,  $height);};            
            $GlobalHistoryService->setInHistory($apCatalogFilesVb, 'new');
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
    public function edit(InterventionImage $intervention, Request $request, ApCatalogFilesVb $apCatalogFilesVb, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $tabName = self::TAB_VB;
        $sector = $apCatalogFilesVb->getSector();
        $sectorId = $sector->getId();
        $form = $this->createForm(ApCatalogFilesVbEditType::class, $apCatalogFilesVb);
        $form->handleRequest($request);
        $ifNewImage = false;
        // dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $fileBefore = $apCatalogFilesVb->getImageFile();
            $imgFile = $apCatalogFilesVb->getImageFile();
            if($imgFile != NULL)
            {            
                $fileExtension =  $imgFile->guessExtension();
                $apCatalogFilesVb->setFileType($fileExtension);
            }

            $manager = $doctrine->getManager();
            if($imgFile == $fileBefore){
            }else{
                $ifNewImage = true;

                dd($$fileExtension);
                if($fileExtension == "pdf"){}else{
                    $width = getimagesize($imgFile)[0];
                    $height = getimagesize($imgFile)[1];                   
                };  
            }

            $apCatalogFilesVb->setUpdatedAt(new \DateTime());
            $manager->persist($apCatalogFilesVb);
            $manager->flush();
             $GlobalHistoryService->setInHistory($apCatalogFilesVb, 'edit');

            if($ifNewImage == true){
                if($fileExtension == "pdf"){}else{
                    $intervention->resizeCatalogBpCarroussel($apCatalogFilesVb->getFileName(), $width, $height);
                };
            }
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

    public function delete(Request $request, ApCatalogFilesVb $apCatalogFilesVb, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $sector = $apCatalogFilesVb->getSector();
        $sectorId = $sector->getId();
        dd($sectorId);
        if ($this->isCsrfTokenValid('delete'.$apCatalogFilesVb->getId(), $request->request->get('_token'))) {
            $GlobalHistoryService->setInHistory($apCatalogFilesVb, 'delete');
            $entityManager = $doctrine->getManager();
            $entityManager->remove($apCatalogFilesVb);
            $entityManager->flush();
        }
        return $this->redirectToRoute('ap_sector_vb_show', ['id' => $sectorId ], Response::HTTP_SEE_OTHER);
    }

    /**
     * @route("/delete/{id}", methods={"GET"})
    */

    public function ajaxDelete(ApCatalogFilesVb $apCatalogFilesVb, ManagerRegistry $doctrine, Request $request, GlobalHistoryService $GlobalHistoryService) : response
    {
        $csrf = $request->get('csrf');
        if ($this->isCsrfTokenValid('delete', $csrf)){
            $GlobalHistoryService->setInHistory($apCatalogFilesVb, 'Ajax delete');
            $manager = $doctrine->getManager();
            $manager->remove($apCatalogFilesVb);
            $manager->flush();
            return $this->json(["code" => 200,
            "message" => "delete"], 200);
        }
    }


    /**
     *@Route("/archive/{id}", name="ap_files_vb_archive", methods={"GET","POST"})
     */
    public function archive(ManagerRegistry $doctrine, ApCatalogFilesVb $apCatalogFilesVb, Request  $request, GlobalHistoryService $GlobalHistoryService): Response
    {   
        $sectorId = $apCatalogFilesVb->getSector()->getId();
        if ($this->isCsrfTokenValid('archiver'.$apCatalogFilesVb->getId(), $request->request->get('_token')))
        {
            if ($apCatalogFilesVb->getArchive() == 0 ){
                $apCatalogFilesVb->setArchive(1);
                $GlobalHistoryService->setInHistory($apCatalogFilesVb, 'Archive');
            }else{
                $apCatalogFilesVb->setArchive(0);
                $GlobalHistoryService->setInHistory($apCatalogFilesVb, 'Unarchive');
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogFilesVb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_sector_vb_show', ['id' => $sectorId], Response::HTTP_SEE_OTHER);
    //       return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
    }

}
