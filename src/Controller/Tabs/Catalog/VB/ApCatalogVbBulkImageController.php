<?php

namespace App\Controller\Tabs\Catalog\VB;

use App\Entity\ApCatalogVbBulkImage;
use App\Form\ApCatalogVbBulkImageType;
use App\Form\ApCatalogVbBulkImageEditType;
use App\Repository\ApCatalogVbBulkImageRepository;
use App\Repository\ApCatalogCaseVbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\GlobalHistoryService;
use App\Service\InterventionImage;

/**
 * @Route("/ap/catalog/vb/bulk/image")
 */
class ApCatalogVbBulkImageController extends AbstractController
{

    #region constant
    const TAB_VB = "Velobatterie";
    #endregion

    /**
     * @Route("/", name="catalog_vb_bulk_image_index", methods={"GET"})
     */
    public function index(ApCatalogVbBulkImageRepository $apCatalogVbBulkImageRepository): Response
    {
        $tabName = self::TAB_VB;
        return $this->render('tabs/Catalog/VB/ap_catalog_vb_bulk_image/index.html.twig', [
            'ap_catalog_vb_bulk_images' => $apCatalogVbBulkImageRepository->findAll(),
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/new/{id}", name="catalog_vb_bulk_image_new", methods={"GET", "POST"})
     */
    public function new(InterventionImage $intervention, Request $request, ApCatalogCaseVbRepository $caseRepository,ManagerRegistry $doctrine, GlobalHistoryService $GlobalHistoryService, ApCatalogVbBulkImageRepository $bulkImageRepo ): Response
    {
        $tabName = self::TAB_VB;
        $caseId = intval(basename("$_SERVER[REQUEST_URI]"));
        $apCatalogVbBulkImage = new ApCatalogVbBulkImage();
        $form = $this->createForm(ApCatalogVbBulkImageType::class, $apCatalogVbBulkImage);
        $form->handleRequest($request);
        $case = $caseRepository->find($caseId);
        $actualImageThumb = $bulkImageRepo->findOneMiniature(['caseIs' => $case]);
        if ($form->isSubmitted() && $form->isValid()) {
            $apCatalogVbBulkImage->setUser($this->getUser());

            $imgFile = $apCatalogVbBulkImage->getImageFile();
            $fileExtension =  $imgFile->guessExtension();

            $apCatalogVbBulkImage->setCreatedAt(new \DateTime());
            $apCatalogVbBulkImage->setCaseIs($case);

            $apCatalogVbBulkImage->setFileSize(filesize($imgFile)/1024);
            $apCatalogVbBulkImage->setFileType($fileExtension);

            $width = getimagesize($imgFile)[0];
            $height = getimagesize($imgFile)[1];
            $entityManager = $doctrine->getManager();
            if($form['miniature']->getData() == true && $actualImageThumb != null){

                $actualImageThumb->setMiniature(false);
                $entityManager->persist($actualImageThumb);
            }
            $entityManager->persist($apCatalogVbBulkImage);
            $entityManager->flush();

            $intervention->resizeCatalogVbCarroussel($apCatalogVbBulkImage->getFileName(), $width,  $height);

            $GlobalHistoryService->setInHistory($apCatalogVbBulkImage, 'new');

            return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $caseId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_catalog_vb_bulk_image/new.html.twig', [
            'ap_catalog_vb_bulk_image' => $apCatalogVbBulkImage,
            'form' => $form,
            'tabName' => $tabName,
            'caseId' => $caseId,
        ]);
    }

    /**
     * @Route("/{id}", name="catalog_vb_bulk_image_show", methods={"GET"})
     */
    public function show(ApCatalogVbBulkImage $apCatalogVbBulkImage): Response
    {
        $tabName = self::TAB_VB;
        return $this->render('tabs/Catalog/VB/ap_catalog_vb_bulk_image/show.html.twig', [
            'ap_catalog_vb_bulk_image' => $apCatalogVbBulkImage,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="catalog_vb_bulk_image_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApCatalogVbBulkImage $apCatalogVbBulkImage, ApCatalogVbBulkImageRepository $apCatalogVbBulkImageRepository): Response
    {
        $caseId = $apCatalogVbBulkImage->getCaseIs()->getId();
        $actualImageThumb = $apCatalogVbBulkImageRepository->findOneMiniature(['caseIs' => $apCatalogVbBulkImage->getCaseIs()]);
        $tabName = self::TAB_VB;
        $form = $this->createForm(ApCatalogVbBulkImageEditType::class, $apCatalogVbBulkImage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form['miniature']->getData() == true && $actualImageThumb != null){
                $actualImageThumb->setMiniature(false);
                $apCatalogVbBulkImageRepository->add($actualImageThumb);
                $apCatalogVbBulkImage->setMiniature(true);
            }
            // dd($apCatalogVbBulkImage);
            $apCatalogVbBulkImage->setUpdatedAt(new \DateTime());
            $apCatalogVbBulkImageRepository->add($apCatalogVbBulkImage);
            return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $caseId], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/VB/ap_catalog_vb_bulk_image/edit.html.twig', [
            'ap_catalog_vb_bulk_image' => $apCatalogVbBulkImage,
            'form' => $form,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}", name="catalog_vb_bulk_image_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogVbBulkImage $apCatalogVbBulkImage, ManagerRegistry $doctrine): Response
    {

        $caseId = $apCatalogVbBulkImage->getCaseIs()->getId();
        if ($this->isCsrfTokenValid('delete'.$apCatalogVbBulkImage->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($apCatalogVbBulkImage);
            $entityManager->flush();
        }

        
        return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $caseId], Response::HTTP_SEE_OTHER);
    }

    /**
     *@Route("/archive/{id}", name="catalog_vb_bulk_image_archive", methods={"GET","POST"})
     */
    public function archive(ManagerRegistry $doctrine, ApCatalogVbBulkImage $apCatalogVbBulkImage , Request  $request, GlobalHistoryService $GlobalHistoryService): Response
    {   
        $caseId = $apCatalogVbBulkImage->getCaseIs()->getId();
        if ($this->isCsrfTokenValid('archiver'.$apCatalogVbBulkImage->getId(), $request->request->get('_token')))
        {
            if ($apCatalogVbBulkImage->getArchive() == 0 ){
                $apCatalogVbBulkImage->setArchive(1);
                $GlobalHistoryService->setInHistory($apCatalogVbBulkImage, 'Archive');
            }else{
                $apCatalogVbBulkImage->setArchive(0);
                $GlobalHistoryService->setInHistory($apCatalogVbBulkImage, 'Unarchive');
            }
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apCatalogVbBulkImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_catalog_case_vb_show', ['id' => $caseId], Response::HTTP_SEE_OTHER);
    //       return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @route("/delete/{id}", methods={"GET"})
    */

    public function ajaxDelete(ApCatalogVbBulkImage $apCatalogVbBulkImage, ManagerRegistry $doctrine, Request $request, GlobalHistoryService $GlobalHistoryService) : response
    {
        $csrf = $request->get('csrf');
        if ($this->isCsrfTokenValid('delete', $csrf)){
            $GlobalHistoryService->setInHistory($apCatalogVbBulkImage, 'Ajax delete');
             $manager = $doctrine->getManager();
             $manager->remove($apCatalogVbBulkImage);
             $manager->flush();
            return $this->json(["code" => 200,
            "message" => "delete"], 200);
         }
    }

}
