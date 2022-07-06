<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationSection;
use App\Form\ApInformationSectionType;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationFilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GlobalHistoryService;
use App\Repository\ApInformationParentSectionRepository;


/**
 * @Route("/information/section")
 */
class ApInformationSectionController extends AbstractController
{

    public const TAB_QSE = "QSE";
    public const TAB_RH = "RH";
    public const TAB_REF_QSE ="Qse";
    public const TAB_REF_RH ="Rh";

    /**
     * @Route("/", name="information_section_index", methods={"GET"})
     */
    public function index(ApInformationFilesRepository $apInformationFilesRepository): Response
    {
        $recentFiles = $apInformationFilesRepository->findRecentFiles();
        return $this->render('tabs/information/ap_information_section/index.html.twig', [
            'files' => $recentFiles,
        ]);
    }

    /**
     * @Route("/new/rh", name="information_section_new_rh", methods={"GET", "POST"})
     */
    public function newRh(Request $request, ApInformationSectionRepository $apInformationSectionRepository, GlobalHistoryService $globalHistoryService, ApInformationParentSectionRepository $parentRepo): Response
    {
        $apInformationSection = new ApInformationSection();
        $form = $this->createForm(ApInformationSectionType::class, $apInformationSection);
        $form->handleRequest($request);
        // $parentId = intval(basename("$_SERVER[REQUEST_URI]"));
        $tabName = self::TAB_RH;
        if ($form->isSubmitted() && $form->isValid()) {
            // $parent = $parentRepo->find($parentId);
            $apInformationSection->setParentSection(Null);
            $apInformationSection->setState(1);
            $apInformationSectionRepository->add($apInformationSection);
            $globalHistoryService->setInHistory($apInformationSection, 'new rh');
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/information/ap_information_section/new_rh.html.twig', [
            'ap_information_section' => $apInformationSection,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/new/qse/{id}", name="information_section_new_qse", methods={"GET", "POST"})
     */
    public function newQse(Request $request, ApInformationSectionRepository $apInformationSectionRepository, GlobalHistoryService $globalHistoryService, ApInformationParentSectionRepository $parentRepo): Response
    {
        $apInformationSection = new ApInformationSection();
        $form = $this->createForm(ApInformationSectionType::class, $apInformationSection);
        $form->handleRequest($request);
        $parentId = intval(basename("$_SERVER[REQUEST_URI]"));
        $tabName = self::TAB_QSE;
        if ($form->isSubmitted() && $form->isValid()) {
            $parent = $parentRepo->find($parentId);
            $apInformationSection->setParentSection($parent);
            $apInformationSection->setState(2);
            $apInformationSectionRepository->add($apInformationSection);
            $globalHistoryService->setInHistory($apInformationSection, 'new qse');
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/information/ap_information_section/new_qse.html.twig', [
            'ap_information_section' => $apInformationSection,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}/edit", name="information_section_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationSection $apInformationSection, ApInformationSectionRepository $apInformationSectionRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $form = $this->createForm(ApInformationSectionType::class, $apInformationSection);
        $form->handleRequest($request);
        $state = $apInformationSection->getState();
        if($state == 1){
            $tabName = self::TAB_RH;
            $actual_tab = self::TAB_REF_RH;
        }else{
            $tabName = self::TAB_QSE;
            $actual_tab = self::TAB_REF_QSE;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationSectionRepository->add($apInformationSection);
            $globalHistoryService->setInHistory($apInformationSection, 'edit');

            if ($state == 1){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
            }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('tabs/information/ap_information_section/edit.html.twig', [
            'section' => $apInformationSection,
            'form' => $form,
            'tabName' => $tabName,
            'actual_tab' => $actual_tab
        ]);
    }

    /**
     * @Route("/{id}", name="information_section_delete", methods={"POST"})
     */
    public function delete(ApInformationFilesRepository $fileRepo, Request $request, ApInformationSection $apInformationSection, ApInformationSectionRepository $apInformationSectionRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $state = $apInformationSection->getState();
        if ($this->isCsrfTokenValid('delete'.$apInformationSection->getId(), $request->request->get('_token'))) {
            // dd($fileRepo->findAllInfoFilesBySector($apInformationSection->getId()));
            if($fileRepo->findAllInfoFilesBySector($apInformationSection->getId()) == NULL){
            $globalHistoryService->setInHistory($apInformationSection, 'delete');
            $apInformationSectionRepository->remove($apInformationSection);
            }
        }

        if ($state == 1){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
            }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
            }
    }


}
