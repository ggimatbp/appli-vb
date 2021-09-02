<?php

namespace App\Controller;

use App\Entity\ApTab;
use App\Form\ApTabType;
use App\Repository\ApTabRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/tab")
 */
class ApTabController extends AbstractController
{
    /**
     * @Route("/", name="ap_tab_index", methods={"GET"})
     */
    public function index(ApTabRepository $apTabRepository): Response
    {
        return $this->render('ap_tab/index.html.twig', [
            'ap_tabs' => $apTabRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_tab_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apTab = new ApTab();
        $form = $this->createForm(ApTabType::class, $apTab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apTab);
            $entityManager->flush();

            return $this->redirectToRoute('ap_tab_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_tab/new.html.twig', [
            'ap_tab' => $apTab,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_tab_show", methods={"GET"})
     */
    public function show(ApTab $apTab): Response
    {
        return $this->render('ap_tab/show.html.twig', [
            'ap_tab' => $apTab,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_tab_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApTab $apTab): Response
    {
        $form = $this->createForm(ApTabType::class, $apTab);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_tab_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_tab/edit.html.twig', [
            'ap_tab' => $apTab,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_tab_delete", methods={"POST"})
     */
    public function delete(Request $request, ApTab $apTab): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apTab->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apTab);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_tab_index', [], Response::HTTP_SEE_OTHER);
    }
}
