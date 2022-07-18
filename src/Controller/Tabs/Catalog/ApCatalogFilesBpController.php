<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApCatalogFilesBp;
use App\Entity\ApCatalogFilesBpHistory;
use App\Entity\ApSectorBp;
use App\Entity\User;
use App\Form\ApCatalogFilesBpType;
use App\Form\ApCatalogFilesBpEditType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ApCatalogFilesBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApSectorBpRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\GlobalHistoryService;
use App\Service\InterventionImage;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @Route("/ap/catalog/files/bp")
 */
class ApCatalogFilesBpController extends AbstractController
{

    #region constant
    const TAB_BP = "Batteries-Prod";
    #endregion


    /**
     * @Route("/new/{id}", name="ap_catalog_files_bp_new", methods={"GET","POST"})
     */
    public function new(InterventionImage $intervention , Request $request, ApCatalogModelBpRepository $apCatalogModelBp, ApSectorBp $apSectorBp, ApSectorBpRepository $ApSectorBpRepository, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine, ApCatalogFilesBpRepository $apCatalogFilesBpRepository): Response
    {
        $tabName = self::TAB_BP;
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();
        $GlobalHistoryService->setInHistory('View', 'ap_catalog_files_bp_new', $ipUser);

        $apCatalogFilesBp = new ApCatalogFilesBp();
        $form = $this->createForm(ApCatalogFilesBpType::class, $apCatalogFilesBp, );
        $form->handleRequest($request);
        $sectorId = intval(basename("$_SERVER[REQUEST_URI]"));

        if ($form->isSubmitted() && $form->isValid()) {
            // $apCatalogFilesBp->setFileName($apCatalogFilesBp->getName());
            
            $sector = $ApSectorBpRepository->find($sectorId);
            $model = $sector->getModel();
            $apCatalogFilesBp->setModel($model);
            $apCatalogFilesBp->setRelation($sector);
            $imgFile = $apCatalogFilesBp->getImageFile();
            $fileExtension =  $imgFile->guessExtension();
            //dd($fileExtension);
            $apCatalogFilesBp->setUser($this->getUser());
            $apCatalogFilesBp->setCreatedAt(new \DateTime());
            $apCatalogFilesBp->setFileSize(filesize($imgFile)/1024);
            $apCatalogFilesBp->setFileType($fileExtension);
            $manager = $doctrine->getManager();
            $width = getimagesize($imgFile)[0];
            $height = getimagesize($imgFile)[1];

    #region auto générate order number

            if($apCatalogFilesBp->getOrderNumber() === NULL)
            {
                if($fileExtension === "pdf")
                {
                    $biggestFileOrderNumber = $apCatalogFilesBpRepository->findBiggestOrderNumberBySectorsForPdf($apCatalogFilesBp->getRelation()->getId());
                }else{
                    $biggestFileOrderNumber = $apCatalogFilesBpRepository->findBiggestOrderNumberBySectorsForOther($apCatalogFilesBp->getRelation()->getId());
                }

                    if( $biggestFileOrderNumber[0] === NULL)
                    {
                        $apCatalogFilesBp->setOrderNumber(0);
                    }else{
                        $biggestOrderNumber = $biggestFileOrderNumber[0]->getOrderNumber();
                        $apCatalogFilesBp->setOrderNumber($biggestOrderNumber + 1);
                    }

                
            }
    #endregion

            $manager->persist($apCatalogFilesBp);
            $manager->flush();
            if($fileExtension == "pdf"){}else{$intervention->resizeCatalogBpCarroussel($apCatalogFilesBp->getFileName(), $width, $height);};
            //set history
            $request = Request::createFromGlobals();
            $ipUser = $request->getClientIp();
            $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'new', $ipUser);
            return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $sectorId], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('tabs/Catalog/ap_catalog_files_bp/new.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
            'form' => $form,
            'tabName' => $tabName,
            'sector_id' => $sectorId
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_files_bp_show", methods={"GET"})
     */
    public function show(ApCatalogFilesBp $apCatalogFilesBp, GlobalHistoryService $GlobalHistoryService): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'View', $ipUser);

        $tabName = self::TAB_BP;
        return $this->render('tabs/Catalog/ap_catalog_files_bp/show.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_files_bp_edit", methods={"GET","POST"})
     */
    public function edit(InterventionImage $intervention, Request $request, ApCatalogFilesBp $apCatalogFilesBp, ApSectorBpRepository $ApSectorBpRepository, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'ViewEdit', $ipUser);

        $tabName = self::TAB_BP;
        $sectorId = $apCatalogFilesBp->getRelation();
        $id = $sectorId->getId();
        $fileBefore = $apCatalogFilesBp->getImageFile();
        $form = $this->createForm(ApCatalogFilesBpEditType::class, $apCatalogFilesBp);
        $form->handleRequest($request);
        $ifNewImage = false;
        if ($form->isSubmitted() && $form->isValid()) {

            $imgFile = $apCatalogFilesBp->getImageFile();
            if($imgFile == $fileBefore){
            }else{
                $ifNewImage = true;
                $fileExtension =  $imgFile->guessExtension();
                $apCatalogFilesBp->setFileType($fileExtension);
                
                if($fileExtension == "pdf"){}else{
                    $width = getimagesize($imgFile)[0];
                    $height = getimagesize($imgFile)[1];                   
                };  
            }
            // dd($apCatalogFilesBp);
            $manager = $doctrine->getManager();
            $manager->persist($apCatalogFilesBp);
            $manager->flush();
            $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'edit', $ipUser);

            if($ifNewImage == true){
                if($fileExtension == "pdf"){}else{
                    $intervention->resizeCatalogBpCarroussel($apCatalogFilesBp->getFileName(), $width, $height);
                };
            }

            return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_files_bp/edit.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
            'form' => $form,
            'tabName' => $tabName,
        ]);
    }



    /**
     * @Route("/{id}", name="ap_catalog_files_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogFilesBp $apCatalogFilesBp, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $relationId = $apCatalogFilesBp->getrelation();
        $id = $relationId->getId();
        if ($this->isCsrfTokenValid('delete'.$apCatalogFilesBp->getId(), $request->request->get('_token'))) {
            $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'delete', $ipUser);
            $entityManager = $doctrine->getManager();
            $entityManager->remove($apCatalogFilesBp);
            $entityManager->flush();

        }

        return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }


    /**
     * @route("/delete/{id}", methods={"GET"})
    */

    public function editotest(ApCatalogFilesBp $apCatalogFilesBp, Request $request, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine) : response
    {
        $csrf = $request->get('csrf');
        if ($this->isCsrfTokenValid('delete', $csrf)){
            $request = Request::createFromGlobals();
            $ipUser = $request->getClientIp();

            $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'delete', $ipUser);
            $manager = $doctrine->getManager();
            $manager->persist($apCatalogFilesBp);
            $manager->flush();

            // $manager = $this->getDoctrine()->getManager();
            $manager->remove($apCatalogFilesBp);
            $manager->flush();
            return $this->json(["code" => 200,
            "message" => "delete"], 200);
        }


    }

    /**
     *@Route("/archive/{id}", name="ap_catalog_files_bp_archive", methods={"GET","POST"})
     */
    public function archive(ApCatalogFilesBp $apCatalogFilesBp, Request  $request, GlobalHistoryService $GlobalHistoryService, ManagerRegistry $doctrine): Response
    {
        $sectorId = $apCatalogFilesBp->getRelation()->getId();
        if ($this->isCsrfTokenValid('archiver'.$apCatalogFilesBp->getId(), $request->request->get('_token')))
            {
                $request = Request::createFromGlobals();
                $ipUser = $request->getClientIp();
                if ($apCatalogFilesBp->getArchive() == 0 ){
                    $apCatalogFilesBp->setArchive(1);
                    $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'archiver', $ipUser);

                }else{
                    $apCatalogFilesBp->setArchive(0);
                    $GlobalHistoryService->setInHistory($apCatalogFilesBp, 'Unarchiver', $ipUser);
                }
                
                $entityManager = $doctrine->getManager();
                $entityManager->persist($apCatalogFilesBp);
                $entityManager->flush();
            }
        return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $sectorId], Response::HTTP_SEE_OTHER);
                //return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
    }
}
