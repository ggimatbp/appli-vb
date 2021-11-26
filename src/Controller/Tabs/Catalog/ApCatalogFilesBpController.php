<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApCatalogFilesBp;
use App\Form\ApCatalogFilesBpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ApCatalogFilesBpRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/new", name="ap_catalog_files_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apCatalogFilesBp = new ApCatalogFilesBp();
        $form = $this->createForm(ApCatalogFilesBpType::class, $apCatalogFilesBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogFilesBp);
            $entityManager->flush();

            return $this->redirectToRoute('ap_catalog_files_bp_index', [], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, ApCatalogFilesBp $apCatalogFilesBp): Response
    {
        $form = $this->createForm(ApCatalogFilesBpType::class, $apCatalogFilesBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_catalog_files_bp_index', [], Response::HTTP_SEE_OTHER);
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
        if ($this->isCsrfTokenValid('delete'.$apCatalogFilesBp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogFilesBp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_catalog_files_bp_index', [], Response::HTTP_SEE_OTHER);
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
