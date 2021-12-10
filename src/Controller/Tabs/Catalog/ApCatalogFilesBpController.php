<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApCatalogFilesBp;
use App\Entity\ApCatalogFilesBpHistory;
use App\Entity\User;
use App\Form\ApCatalogFilesBpType;
use App\Form\ApCatalogFilesBpEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ApCatalogFilesBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use LiipImagineBundleModelBinary;


/**
 * @Route("/ap/catalog/files/bp")
 */
class ApCatalogFilesBpController extends AbstractController
{
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
    public function new(Request $request, ApCatalogModelBpRepository $apCatalogModelBp): Response
    {
        $apCatalogFilesBp = new ApCatalogFilesBp();
        $form = $this->createForm(ApCatalogFilesBpType::class, $apCatalogFilesBp, );
        $form->handleRequest($request);
        $id = intval(basename("$_SERVER[REQUEST_URI]"));
        if ($form->isSubmitted() && $form->isValid()) {
            // $apCatalogFilesBp->setFileName($apCatalogFilesBp->getName());
            $model = $apCatalogModelBp->find($id);
            $apCatalogFilesBp->setModel($model);
            $imgFile = $apCatalogFilesBp->getImageFile();
            $fileExtension =  $imgFile->guessExtension();
            //!! note a moi meme: ici on peut faire un blocage dans le cas ou file extention ne corresponde pas a ce que l'on souhaite
            //test
            // $imageFileCompress = $apCatalogFilesBp->setImageFile($imgFile);;
            //fin du test
            $apCatalogFilesBp->setUser($this->getUser());
            $apCatalogFilesBp->setCreatedAt(new \DateTime());
            $apCatalogFilesBp->setFileSize(filesize($imgFile)/1024);
            
            $apCatalogFilesBp->setFileType($fileExtension);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogFilesBp);
            $entityManager->flush();
            // imagejpeg($apCatalogFilesBp->getFileName(), , =75);
             return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_files_bp/new.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_files_bp_show", methods={"GET"})
     */
    public function show(ApCatalogFilesBp $apCatalogFilesBp): Response
    {
        return $this->render('tabs/Catalog/ap_catalog_files_bp/show.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_files_bp_edit", methods={"GET","POST"})
     */
    public function edit(EntityManagerInterface $manager, Request $request, ApCatalogFilesBp $apCatalogFilesBp ): Response
    {
        $modelId = $apCatalogFilesBp->getModel();
        $id = $modelId->getId();
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
            $ApCatalogFilesBpHistory = New ApCatalogFilesBpHistory();
            $ApCatalogFilesBpHistory->setUser($apCatalogFilesBp->getUser());
            $ApCatalogFilesBpHistory->setFile($apCatalogFilesBp);
            $ApCatalogFilesBpHistory->setUpdateAt(new \DateTimeImmutable());
            $ApCatalogFilesBpHistory->setAction("update");
            $ApCatalogFilesBpHistory->setModelName($apCatalogFilesBp->getModel()->getName());
            $ApCatalogFilesBpHistory->setDocName($apCatalogFilesBp->getFileName());
            $manager->persist($ApCatalogFilesBpHistory);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_catalog_model_bp_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_files_bp/edit.html.twig', [
            'ap_catalog_files_bp' => $apCatalogFilesBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_files_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogFilesBp $apCatalogFilesBp): Response
    {
        $modelId = $apCatalogFilesBp->getModel();
        $id = $modelId->getId();
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
}
