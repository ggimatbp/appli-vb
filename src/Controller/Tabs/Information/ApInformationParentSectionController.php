<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationParentSection;
use App\Form\ApInformationParentSectionType;
use App\Repository\ApInformationParentSectionRepository;
use App\Repository\ApInformationSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GlobalHistoryService;


/**
 * @Route("information/parent/section")
 */
class ApInformationParentSectionController extends AbstractController
{

    public const TAB_QSE = "QSE";
    public const TAB_RH = "RH";
    public const TAB_REF_QSE ="Qse";
    public const TAB_REF_RH ="Rh";

    /**
     * @Route("/", name="information_parent_section_index", methods={"GET"})
     */
    public function index(ApInformationParentSectionRepository $apInformationParentSectionRepository): Response
    {
        return $this->render('tabs/information/ap_information_parent_section/index.html.twig', [
            'ap_information_parent_sections' => $apInformationParentSectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/qse", name="information_parent_section_new_qse", methods={"GET", "POST"})
     */
    public function newQse(Request $request, ApInformationParentSectionRepository $apInformationParentSectionRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();
        $apInformationParentSection = new ApInformationParentSection();
        $form = $this->createForm(ApInformationParentSectionType::class, $apInformationParentSection);
        $form->handleRequest($request);
        $tabName = self::TAB_QSE;
        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationParentSection->setState(2);
            $apInformationParentSectionRepository->add($apInformationParentSection);
            $globalHistoryService->setInHistory($apInformationParentSection, 'New qse', $ipUser);
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/information/ap_information_parent_section/newQse.html.twig', [
            'ap_information_parent_section' => $apInformationParentSection,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/new/rh", name="information_parent_section_new_rh", methods={"GET", "POST"})
    */
    public function newRh(Request $request, ApInformationParentSectionRepository $apInformationParentSectionRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $apInformationParentSection = new ApInformationParentSection();
        $form = $this->createForm(ApInformationParentSectionType::class, $apInformationParentSection);
        $form->handleRequest($request);
        $tabName = self::TAB_RH;
        if ($form->isSubmitted() && $form->isValid()) {
            
            $apInformationParentSection->setState(1);
            $apInformationParentSectionRepository->add($apInformationParentSection);
            $globalHistoryService->setInHistory($apInformationParentSection, 'New rh', $ipUser);
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/information/ap_information_parent_section/newRh.html.twig', [
            'ap_information_parent_section' => $apInformationParentSection,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}/edit", name="information_parent_section_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationParentSection $apInformationParentSection, ApInformationParentSectionRepository $apInformationParentSectionRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $form = $this->createForm(ApInformationParentSectionType::class, $apInformationParentSection);
        $form->handleRequest($request);
        $state = $apInformationParentSection->getState();
        if ($state == 1){
            $tabName = self::TAB_RH;
            $actual_tab = self::TAB_REF_RH;
        }else{
            $tabName = self::TAB_QSE;
            $actual_tab = self::TAB_REF_QSE;
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationParentSectionRepository->add($apInformationParentSection);
            $globalHistoryService->setInHistory($apInformationParentSection, 'Edit', $ipUser);
            if ($state == 1){
                return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
                }else{
                return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
                }
        }

        return $this->renderForm('tabs/information/ap_information_parent_section/edit.html.twig', [
            'parent' => $apInformationParentSection,
            'form' => $form,
            'tabName' => $tabName,
            'actual_tab' => $actual_tab
        ]);
    }

    /**
     * @Route("/{id}", name="information_parent_section_delete", methods={"POST"})
     */
    public function delete(Request $request, ApInformationParentSection $apInformationParentSection, ApInformationParentSectionRepository $apInformationParentSectionRepository, ApInformationSectionRepository $parentSection, GlobalHistoryService $globalHistoryService): Response

    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $state = $apInformationParentSection->getState();
        if ($this->isCsrfTokenValid('delete'.$apInformationParentSection->getId(), $request->request->get('_token'))) {
            if($parentSection->findAllInfoSectorsByParent($apInformationParentSection->getId()) == NULL)
                {
                    $globalHistoryService->setInHistory($apInformationParentSection, 'Delete', $ipUser);
                     $apInformationParentSectionRepository->remove($apInformationParentSection);
                }
        }

            if ($state == 1){
                return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
                }else{
                return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
                }
    }
}
