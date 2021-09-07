<?php

namespace App\Controller;

use App\Entity\ApAccess;
use App\Form\ApAccessType;
use App\Repository\ApAccessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/access")
 */
class ApAccessController extends AbstractController
{
    /**
     * @Route("/", name="ap_access_index", methods={"GET"})
     */
    public function index(ApAccessRepository $apAccessRepository): Response
    {
        return $this->render('ap_access/index.html.twig', [
            'ap_accesses' => $apAccessRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_access_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apAccess = new ApAccess();
        $form = $this->createForm(ApAccessType::class, $apAccess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apAccess);
            $entityManager->flush();

            return $this->redirectToRoute('ap_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_access/new.html.twig', [
            'ap_access' => $apAccess,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_access_show", methods={"GET"})
     */
    public function show(ApAccess $apAccess): Response
    {
        return $this->render('ap_access/show.html.twig', [
            'ap_access' => $apAccess,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_access_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApAccess $apAccess): Response
    {
        $form = $this->createForm(ApAccessType::class, $apAccess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_access/edit.html.twig', [
            'ap_access' => $apAccess,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_access_delete", methods={"POST"})
     */
    public function delete(Request $request, ApAccess $apAccess): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apAccess->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apAccess);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_access_index', [], Response::HTTP_SEE_OTHER);
    }
}