<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationFiles;
use App\Form\ApInformationFilesType;
use App\Repository\ApInformationFilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApInformationSectionRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\GlobalHistoryService;
use App\Entity\ApInformationParapher;
use App\Repository\UserRepository;
use App\Repository\ApInformationParapherRepository;



/**
 * @Route("/information/files")
 */
class ApInformationFilesController extends AbstractController
{

    #region constant
    public const TAB_RH = "RH";
    public const TAB_QSE = "QSE";
    public const TAB_REF_QSE ="Qse";
    public const TAB_REF_RH ="Rh";
    #endregion

    /**
     * @Route("/", name="information_files_index", methods={"GET"})
     */
    public function index(ApInformationFilesRepository $apInformationFilesRepository): Response
    {

        $recentRhFiles = $apInformationFilesRepository->findRecentRhFiles();
        $recentQseFiles = $apInformationFilesRepository->findRecentRhFiles();
        $lastRhFile = $apInformationFilesRepository->findLastRhFiles();
        $lastQseFile = $apInformationFilesRepository->findLastQseFiles();

        return $this->render('tabs/information/ap_information_files/index.html.twig', [
            'rh_files' => $recentRhFiles,
            'qse_files' => $recentQseFiles,
            'rh_file' => $lastRhFile,
            'qse_file' => $lastQseFile
        ]);
    }

    /**
     * @Route("/new/{id}", name="information_files_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ApInformationSectionRepository $sectionRepository, ManagerRegistry $doctrine, GlobalHistoryService $globalHistoryService, UserRepository $userRepo): Response
    {
        $apInformationFile = new ApInformationFiles();
        $form = $this->createForm(ApInformationFilesType::class, $apInformationFile);
        $form->handleRequest($request);
        $sectionId = intval(basename("$_SERVER[REQUEST_URI]"));
        $section = $sectionRepository->find($sectionId);
        $state = $section->getState();
        if($sectionRepository->find($sectionId)->getState() == 1)
            {
                $tabName = self::TAB_RH;
                $actual_tab = self::TAB_REF_RH;
            }else{
                $tabName = self::TAB_QSE;
                $actual_tab = self::TAB_REF_QSE;
            }
        if ($form->isSubmitted() && $form->isValid()) {

            $apInformationFile->setSection($section);
            $imgFile = $apInformationFile->getImageFile();
            
            $fileExtension =  $imgFile->guessExtension();
            $apInformationFile->setCreatedAt(new \DateTime());
            $apInformationFile->setFileSize(filesize($imgFile)/1024);
            $apInformationFile->setFileType($fileExtension);
            // $apInformationFilesRepository->add($apInformationFile);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($apInformationFile);
           // dd($apInformationFile);
           $entityManager->flush();
            $globalHistoryService->setInHistory($apInformationFile, 'new');
            if(isset($_POST['parapher']))
            {
                $allUser = $userRepo->findAll();

                foreach($allUser as $user){

                    $apInformationParapher = new ApInformationParapher();
                    $apInformationParapher->setFileId($apInformationFile);
                    $apInformationParapher->setUser($user);
                    $entityManager->persist($apInformationParapher);
                }

            }
            $entityManager->flush();

            if($section->getState() === 2){
                return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
            }
         
        }

        return $this->renderForm('tabs/information/ap_information_files/new.html.twig', [
            'ap_information_file' => $apInformationFile,
            'form' => $form,
            'tabName' => $tabName,
            'state' => $state,
            'actual_tab' => $actual_tab
        ]);
    }


    /**
     * @Route("/{id}", name="information_files_show", methods={"GET"})
     */
    public function show(ApInformationFiles $apInformationFile, ApInformationParapherRepository $apInformationParapherRepo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $fileToParaph = $apInformationParapherRepo->findByUserAndFile($user, $apInformationFile);

        $sectionState = $apInformationFile->getSection()->getState();
        if ($sectionState == 1){
            $tabName = self::TAB_RH;
            $actual_tab = self::TAB_REF_RH;
        }else{
            $tabName = self::TAB_QSE;
            $actual_tab = self::TAB_REF_QSE;
        }
        return $this->render('tabs/information/ap_information_files/show.html.twig', [
            'file' => $apInformationFile,
            'tabName' => $tabName,
            'actual_tab' => $actual_tab,
            'parapher' => $fileToParaph
        ]);
    }

    /**
     * @Route("/{id}/edit", name="information_files_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationFiles $apInformationFile, ApInformationFilesRepository $apInformationFilesRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $form = $this->createForm(ApInformationFilesType::class, $apInformationFile);
        $form->handleRequest($request);
        $state = $apInformationFile->getSection()->getState();
        if ($state == 1){
            $tabName = self::TAB_RH;
            $actual_tab = self::TAB_REF_RH;
        }else{
            $tabName = self::TAB_QSE;
            $actual_tab = self::TAB_REF_QSE;
        }
        

        if ($form->isSubmitted() && $form->isValid()) {
            $apInformationFilesRepository->add($apInformationFile);
            $globalHistoryService->setInHistory($apInformationFile, 'edit');

            if ($state == 1){
                return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
            }else{
                return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('tabs/information/ap_information_files/edit.html.twig', [
            'ap_information_file' => $apInformationFile,
            'form' => $form,
            'tabName' => $tabName,
            'actual_tab' => $actual_tab,
            'state' => $state
        ]);
    }

    /**
     * @Route("/{id}", name="information_files_delete", methods={"POST"})
     */
    public function delete(Request $request, ApInformationFiles $apInformationFile, ApInformationFilesRepository $apInformationFilesRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $section = $apInformationFile->getSection();
        $sectionState = $section->getState();
        if ($this->isCsrfTokenValid('delete'.$apInformationFile->getId(), $request->request->get('_token'))) {
            $globalHistoryService->setInHistory($apInformationFile, 'delete');
            $apInformationFilesRepository->remove($apInformationFile);

        }
        if($sectionState == 1){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("archive/{id}", name="information_files_archive", methods={"POST"})
     */
    public function archive(Request $request, ApInformationFiles $apInformationFile, ApInformationFilesRepository $apInformationFilesRepository, GlobalHistoryService $globalHistoryService): Response
    {
        $section = $apInformationFile->getSection();
        $sectionState = $section->getState();
        if ($this->isCsrfTokenValid('archiver'.$apInformationFile->getId(), $request->request->get('_token'))) {
            if($apInformationFile->getArchive() == 0){
                $apInformationFile->setArchive(1);
                $globalHistoryService->setInHistory($apInformationFile, 'archived');
            }else{
                $apInformationFile->setArchive(0);
                $globalHistoryService->setInHistory($apInformationFile, 'unarchived');
            }
            $apInformationFilesRepository->add($apInformationFile);
        }
        if($sectionState == 1){
            return $this->redirectToRoute('information_rh_index', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('information_qse_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
    * @route("/parapher/{id}", methods={"GET"})
    */

    public function parapher(Request $request,GlobalHistoryService $globalHistoryService, ApInformationParapherRepository $apInformationParapherRepo) : response
    {
        $submittedToken = $request->get('editCsrf');
        // 'search-item' is the same value used in the template to generate the token

        $parapherId = $request->get('id');
        $parapher = $apInformationParapherRepo->find($parapherId);
            if ($this->isCsrfTokenValid('edit-item', $submittedToken)) {
                $globalHistoryService->setInHistory($parapher, 'read and approved');
                $parapher->setState(1);
                $parapher->setDateTime(new \DateTime());
                $apInformationParapherRepo->add($parapher);


            return $this->json(["code" => 200,
            "message" => "Lu et approuvé"], 200);
            }

    }
}
