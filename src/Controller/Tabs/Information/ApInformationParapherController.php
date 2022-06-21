<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationParapher;
use App\Form\ApInformationParapherType;
use App\Repository\ApInformationParapherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/information/parapher")
 */
class ApInformationParapherController extends AbstractController
{
    /**
     * @Route("/", name="app_ap_information_parapher_index", methods={"GET"})
     */
    public function index(ApInformationParapherRepository $apInformationParapherRepository): Response
    {
        return $this->render('ap_information_parapher/index.html.twig', [
            'ap_information_paraphers' => $apInformationParapherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ap_information_parapher_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ApInformationParapherRepository $apInformationParapherRepository): Response
    {
        $apInformationParapher = new ApInformationParapher();
        $form = $this->createForm(ApInformationParapherType::class, $apInformationParapher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationParapherRepository->add($apInformationParapher);
            return $this->redirectToRoute('app_ap_information_parapher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_information_parapher/new.html.twig', [
            'ap_information_parapher' => $apInformationParapher,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ap_information_parapher_show", methods={"GET"})
     */
    public function show(ApInformationParapher $apInformationParapher): Response
    {
        return $this->render('ap_information_parapher/show.html.twig', [
            'ap_information_parapher' => $apInformationParapher,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ap_information_parapher_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationParapher $apInformationParapher, ApInformationParapherRepository $apInformationParapherRepository): Response
    {
        $form = $this->createForm(ApInformationParapherType::class, $apInformationParapher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationParapherRepository->add($apInformationParapher);
            return $this->redirectToRoute('app_ap_information_parapher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_information_parapher/edit.html.twig', [
            'ap_information_parapher' => $apInformationParapher,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ap_information_parapher_delete", methods={"POST"})
     */
    public function delete(Request $request, ApInformationParapher $apInformationParapher, ApInformationParapherRepository $apInformationParapherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apInformationParapher->getId(), $request->request->get('_token'))) {
            $apInformationParapherRepository->remove($apInformationParapher);
        }

        return $this->redirectToRoute('app_ap_information_parapher_index', [], Response::HTTP_SEE_OTHER);
    }
}
