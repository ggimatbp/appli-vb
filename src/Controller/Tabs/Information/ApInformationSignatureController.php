<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationSignature;
use App\Form\ApInformationSignatureType;
use App\Repository\ApInformationSignatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/information/signature")
 */
class ApInformationSignatureController extends AbstractController
{
    /**
     * @Route("/", name="app_ap_information_signature_index", methods={"GET"})
     */
    public function index(ApInformationSignatureRepository $apInformationSignatureRepository): Response
    {
        return $this->render('ap_information_signature/index.html.twig', [
            'ap_information_signatures' => $apInformationSignatureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ap_information_signature_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ApInformationSignatureRepository $apInformationSignatureRepository): Response
    {
        $apInformationSignature = new ApInformationSignature();
        $form = $this->createForm(ApInformationSignatureType::class, $apInformationSignature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationSignatureRepository->add($apInformationSignature);
            return $this->redirectToRoute('app_ap_information_signature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_information_signature/new.html.twig', [
            'ap_information_signature' => $apInformationSignature,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ap_information_signature_show", methods={"GET"})
     */
    public function show(ApInformationSignature $apInformationSignature): Response
    {
        return $this->render('ap_information_signature/show.html.twig', [
            'ap_information_signature' => $apInformationSignature,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ap_information_signature_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationSignature $apInformationSignature, ApInformationSignatureRepository $apInformationSignatureRepository): Response
    {
        $form = $this->createForm(ApInformationSignatureType::class, $apInformationSignature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationSignatureRepository->add($apInformationSignature);
            return $this->redirectToRoute('app_ap_information_signature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_information_signature/edit.html.twig', [
            'ap_information_signature' => $apInformationSignature,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ap_information_signature_delete", methods={"POST"})
     */
    public function delete(Request $request, ApInformationSignature $apInformationSignature, ApInformationSignatureRepository $apInformationSignatureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apInformationSignature->getId(), $request->request->get('_token'))) {
            $apInformationSignatureRepository->remove($apInformationSignature);
        }

        return $this->redirectToRoute('app_ap_information_signature_index', [], Response::HTTP_SEE_OTHER);
    }
}
