<?php

namespace App\Controller\Tabs\Catalog\VB;

use App\Entity\ApCatalogCaseVb;
use App\Form\ApCatalogCaseVbType;
use App\Repository\ApCatalogCaseVbRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('tabs/Catalog/VB/ap_catalog_case_vb/index.html.twig', [
            'ap_catalog_case_vbs' => $apCatalogCaseVbRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new", name="ap_catalog_case_vb_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tabName = self::TAB_VB;
        $apCatalogCaseVb = new ApCatalogCaseVb();
        $form = $this->createForm(ApCatalogCaseVbType::class, $apCatalogCaseVb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogCaseVb);
            $entityManager->flush();

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
    public function show(ApCatalogCaseVb $apCatalogCaseVb): Response
    {
        $tabName = self::TAB_VB;
        return $this->render('tabs/Catalog/VB/ap_catalog_case_vb/show.html.twig', [
            'ap_catalog_case_vb' => $apCatalogCaseVb,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_case_vb_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogCaseVb $apCatalogCaseVb): Response
    {
        $tabName = self::TAB_VB;
        $form = $this->createForm(ApCatalogCaseVbType::class, $apCatalogCaseVb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

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
    public function delete(Request $request, ApCatalogCaseVb $apCatalogCaseVb): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apCatalogCaseVb->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogCaseVb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('catalog_index', ['roleback' => 2], Response::HTTP_SEE_OTHER);
    }
}
