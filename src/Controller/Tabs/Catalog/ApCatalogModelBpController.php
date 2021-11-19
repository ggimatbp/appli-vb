<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApCatalogModelBp;
use App\Form\ApCatalogModelBpType;
use App\Repository\ApCatalogModelBpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/catalog/model/bp")
 */
class ApCatalogModelBpController extends AbstractController
{
    /**
     * @Route("/", name="ap_catalog_model_bp_index", methods={"GET"})
     */
    public function index(ApCatalogModelBpRepository $apCatalogModelBpRepository): Response
    {
        return $this->render('ap_catalog_model_bp/index.html.twig', [
            'ap_catalog_model_bps' => $apCatalogModelBpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_catalog_model_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apCatalogModelBp = new ApCatalogModelBp();
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogModelBp);
            $entityManager->flush();

            return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_catalog_model_bp/new.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_model_bp_show", methods={"GET"})
     */
    public function show(ApCatalogModelBp $apCatalogModelBp): Response
    {
        return $this->render('ap_catalog_model_bp/show.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_model_bp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogModelBp $apCatalogModelBp): Response
    {
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_catalog_model_bp/edit.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_model_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogModelBp $apCatalogModelBp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apCatalogModelBp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogModelBp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
    }
}
