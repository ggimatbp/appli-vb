<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApCatalogFilesBp;
use App\Entity\ApCatalogFilesBpHistory;
use App\Entity\ApSectorBp;
use App\Entity\User;
use App\Form\ApCatalogFilesBpType;
use App\Form\ApCatalogFilesBpEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ApCatalogFilesBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApSectorBpRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use LiipImagineBundleModelBinary;


/**
 * @Route("/ap/catalog/files/bp")
 */
class ApCatalogFilesBpController extends AbstractController
{

    #region constant
    const TAB_BP = "Batteries-Prod";
    #endregion

    /**
     * @Route("/", name="ap_catalog_files_bp_index", methods={"GET"})
     */
    public function index(ApCatalogFilesBpRepository $apCatalogFilesBpRepository): Response
    {

        return $this->render('tabs/Catalog/ap_catalog_files_bp/index.html.twig', [
            'ap_catalog_files_bps' => $apCatalogFilesBpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="ap_catalog_files_bp_new", methods={"GET","POST"})
     */
    public function new(EntityManagerInterface $manager, Request $request, ApCatalogModelBpRepository $apCatalogModelBp, ApSectorBp $apSectorBp, ApSectorBpRepository $ApSectorBpRepository): Response
    {
        $tabName = self::TAB_BP;
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

            $apCatalogFilesBp->setUser($this->getUser());
            $apCatalogFilesBp->setCreatedAt(new \DateTime());
            $apCatalogFilesBp->setFileSize(filesize($imgFile)/1024);
            
            $apCatalogFilesBp->setFileType($fileExtension);
            $manager->persist($apCatalogFilesBp);
            $this->getDoctrine()->getManager()->flush();
            //we set history
            $ApCatalogFilesBpHistory = New ApCatalogFilesBpHistory();
            $ApCatalogFilesBpHistory->setUser($apCatalogFilesBp->getUser()->getId());
            $ApCatalogFilesBpHistory->setFile($apCatalogFilesBp->getId());
            $ApCatalogFilesBpHistory->setUpdateAt(new \DateTimeImmutable());
            $ApCatalogFilesBpHistory->setAction("create");
            $ApCatalogFilesBpHistory->setModelName($model->getName());
            $ApCatalogFilesBpHistory->setDocName($apCatalogFilesBp->getFileName());
            $manager->persist($ApCatalogFilesBpHistory);
            // end of setting history
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->flush();
            // imagejpeg($apCatalogFilesBp->getFileName(), , =75);
            $this->getDoctrine()->getManager()->flush();
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
    public function show(ApCatalogFilesBp $apCatalogFilesBp): Response
    {
        $tabName = self::TAB_BP;
        return $this->render('tabs/Catalog/ap_catalog_files_bp/show.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
            'tabName' => $tabName,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_files_bp_edit", methods={"GET","POST"})
     */
    public function edit(EntityManagerInterface $manager, Request $request, ApCatalogFilesBp $apCatalogFilesBp ): Response
    {
        $tabName = self::TAB_BP;
        $sectorId = $apCatalogFilesBp->getRelation();
        $id = $sectorId->getId();
        $fileBefore = $apCatalogFilesBp->getImageFile();
        $form = $this->createForm(ApCatalogFilesBpEditType::class, $apCatalogFilesBp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $imgFile = $apCatalogFilesBp->getImageFile();
            if($imgFile == $fileBefore){
            }else{
                $fileExtension =  $imgFile->guessExtension();
                $apCatalogFilesBp->setFileType($fileExtension);
            }
            $manager->persist($apCatalogFilesBp);
            $this->getDoctrine()->getManager()->flush();
            
            $ApCatalogFilesBpHistory = New ApCatalogFilesBpHistory();
            $ApCatalogFilesBpHistory->setUser($apCatalogFilesBp->getUser()->getId());
            $ApCatalogFilesBpHistory->setFile($apCatalogFilesBp->getId());
            $ApCatalogFilesBpHistory->setUpdateAt(new \DateTimeImmutable());
            $ApCatalogFilesBpHistory->setAction("edit");
            $ApCatalogFilesBpHistory->setModelName($apCatalogFilesBp->getModel()->getName());
            $ApCatalogFilesBpHistory->setDocName($apCatalogFilesBp->getFileName());
            $manager->persist($ApCatalogFilesBpHistory);
            $this->getDoctrine()->getManager()->flush();

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
    public function delete(Request $request, ApCatalogFilesBp $apCatalogFilesBp): Response
    {
        $relationId = $apCatalogFilesBp->getrelation();
        $id = $relationId->getId();
        if ($this->isCsrfTokenValid('delete'.$apCatalogFilesBp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogFilesBp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $id], Response::HTTP_SEE_OTHER);
    }


    /**
     * @route("/delete/{id}", methods={"GET"})
    */

    public function editotest(ApCatalogFilesBp $apCatalogFilesBp, EntityManagerInterface $manager) : response
    {

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($apCatalogFilesBp);
            $manager->flush();
            return $this->json(["code" => 200,
            "message" => "delete"], 200);

    }

    /**
     *@Route("/archive/{id}", name="ap_catalog_files_bp_archive", methods={"GET","POST"})
     */
    public function archive(ApCatalogFilesBp $apCatalogFilesBp): Response
    {
        if ($apCatalogFilesBp->getArchive() == 0 ){
            $apCatalogFilesBp->setArchive(1);
        }else{
            $apCatalogFilesBp->setArchive(0);
        }
       $sectorId = $apCatalogFilesBp->getRelation()->getId();
       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->persist($apCatalogFilesBp);
       $entityManager->flush();
       return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $sectorId], Response::HTTP_SEE_OTHER);
//       return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
    }
}
