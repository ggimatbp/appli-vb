<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationSection;
use App\Form\ApInformationSectionType;
use App\Repository\ApInformationSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/information/section")
 */
class ApInformationSectionController extends AbstractController
{
    /**
     * @Route("/", name="information_section_index", methods={"GET"})
     */
    public function index(ApInformationSectionRepository $apInformationSectionRepository): Response
    {
        return $this->render('tabs/information/ap_information_section/index.html.twig', [
            'ap_information_sections' => $apInformationSectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/rh", name="information_section_new_rh", methods={"GET", "POST"})
     */
    public function newRh(Request $request, ApInformationSectionRepository $apInformationSectionRepository): Response
    {
        $apInformationSection = new ApInformationSection();
        $form = $this->createForm(ApInformationSectionType::class, $apInformationSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationSection->setState(1);
            $apInformationSectionRepository->add($apInformationSection);
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/information/ap_information_section/new_rh.html.twig', [
            'ap_information_section' => $apInformationSection,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new/qse", name="information_section_new_qse", methods={"GET", "POST"})
     */
    public function newQse(Request $request, ApInformationSectionRepository $apInformationSectionRepository): Response
    {
        $apInformationSection = new ApInformationSection();
        $form = $this->createForm(ApInformationSectionType::class, $apInformationSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationSection->setState(2);
            $apInformationSectionRepository->add($apInformationSection);
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/information/ap_information_section/new_qse.html.twig', [
            'ap_information_section' => $apInformationSection,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="information_section_show", methods={"GET"})
     */
    public function show(ApInformationSection $apInformationSection): Response
    {
        return $this->render('tabs/information/ap_information_section/show.html.twig', [
            'ap_information_section' => $apInformationSection,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="information_section_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationSection $apInformationSection, ApInformationSectionRepository $apInformationSectionRepository): Response
    {
        $form = $this->createForm(ApInformationSectionType::class, $apInformationSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $state = $apInformationSection->getState();
            $apInformationSectionRepository->add($apInformationSection);
            if ($state == 1){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
            }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('tabs/information/ap_information_section/edit.html.twig', [
            'section' => $apInformationSection,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="information_section_delete", methods={"POST"})
     */
    public function delete(Request $request, ApInformationSection $apInformationSection, ApInformationSectionRepository $apInformationSectionRepository): Response
    {
        $state = $apInformationSection->getState();
        if ($this->isCsrfTokenValid('delete'.$apInformationSection->getId(), $request->request->get('_token'))) {
            $apInformationSectionRepository->remove($apInformationSection);
        }

        if ($state == 1){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
            }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
            }
    }

    /**
     * @Route("/{id}/archive", name="information_section_archive", methods={"POST"})
     */
    public function archive(Request $request, ApInformationSection $apInformationSection, ApInformationSectionRepository $apInformationSectionRepository): Response
    {
        $state = $apInformationSection->getState();
        if ($this->isCsrfTokenValid('archiver'.$apInformationSection->getId(), $request->request->get('_token'))) {
            
            if($apInformationSection->getArchive() == 1 ){
                $apInformationSection->setArchive(0);
            }else{
                $apInformationSection->setArchive(1);
            }
            
            $apInformationSectionRepository->add($apInformationSection);
        }
        if($state === 1 ){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
        }
        
    }
}
