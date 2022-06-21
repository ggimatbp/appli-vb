<?php

namespace App\Controller\Tabs\Information;

use App\Entity\ApInformationFiles;
use App\Repository\UserRepository;
use App\Entity\ApInformationViewed;
use App\Form\ApInformationFilesType;
use App\Form\ApInformationFilesEditType;
use App\Entity\ApInformationParapher;
use App\Service\GlobalHistoryService;
use App\Entity\ApInformationSignature;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ApInformationFilesRepository;
use App\Repository\ApInformationViewedRepository;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationParapherRepository;
use App\Repository\ApInformationSignatureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



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
        $allUser = $userRepo->findAll();
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

           $entityManager->flush();
            $globalHistoryService->setInHistory($apInformationFile, 'new');

                

            $ChoseUsers = explode(",", $_POST['choseUsers']);
            $usersArray = [];
            foreach ($ChoseUsers as $ChoseUser) {
                $user = intval($ChoseUser);
                $userObj = $userRepo->find($user);
                array_push($usersArray, $userObj);
            }

            if(isset($_POST['parapher']))
            {
                foreach($usersArray as $user){

                    $apInformationParapher = new ApInformationParapher();
                    $apInformationParapher->setFileId($apInformationFile);
                    $apInformationParapher->setUser($user);
                    $entityManager->persist($apInformationParapher);
                }
            }

            if(isset($_POST['signature']))
            {
                foreach($usersArray as $user){

                    $apInformationSignature = new ApInformationSignature();
                    $apInformationSignature->setFile($apInformationFile);
                    $apInformationSignature->setUser($user);
                    $entityManager->persist($apInformationSignature);
                }
            }

            // viewed for all users, the logic will change after when we will use target users
            foreach($usersArray as $user){
                $apInformationParapher = new ApInformationViewed();
                $apInformationParapher->setFile($apInformationFile);
                $apInformationParapher->setUser($user);
                $entityManager->persist($apInformationParapher);
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
            'actual_tab' => $actual_tab,
            'users' => $allUser
        ]);
    }


    /**
     * @Route("/{id}", name="information_files_show", methods={"GET"})
     */
    public function show(ApInformationFiles $apInformationFile, ApInformationParapherRepository $apInformationParapherRepo, ApInformationSignatureRepository $apInformationSignatureRepository, ApInformationViewedRepository $apInformationViewedRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $fileToParaph = $apInformationParapherRepo->findByUserAndFile($user, $apInformationFile);
        $fileTosign = $apInformationSignatureRepository->findByUserAndFile($user, $apInformationFile);
        $fileToView = $apInformationViewedRepository->findByUserAndFile($user, $apInformationFile);
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
            'parapher' => $fileToParaph,
            'signature' => $fileTosign,
            'viewed' => $fileToView,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="information_files_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ApInformationFiles $apInformationFile, ApInformationFilesRepository $apInformationFilesRepository, GlobalHistoryService $globalHistoryService, UserRepository $userRepo, ApInformationViewedRepository $apInformationViewedRepository, ApInformationParapherRepository $apInformationParapherRepo, ApInformationSignatureRepository $apInformationSignatureRepository): Response
    {
        $form = $this->createForm(ApInformationFilesEditType::class, $apInformationFile);
        $form->handleRequest($request);
        $state = $apInformationFile->getSection()->getState();
        $allUser = $userRepo->findAll();
        $paraphers =  $apInformationParapherRepo->findByFile($apInformationFile);
        $signatures = $apInformationSignatureRepository->findByFile($apInformationFile);
        $allUserViewed = $apInformationViewedRepository->findByFile($apInformationFile);
        $oldUsers = [];
        foreach($allUserViewed as $userViewed){
            array_push($oldUsers, $userViewed->getUser()->getId());
        }
        if ($state == 1){
            $tabName = self::TAB_RH;
            $actual_tab = self::TAB_REF_RH;
        }else{
            $tabName = self::TAB_QSE;
            $actual_tab = self::TAB_REF_QSE;
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            #region target edit

            $ChoseUsers = explode(",", $_POST['choseUsers']);
            $newUsers = [];
                foreach ($ChoseUsers as $ChoseUser) {
                    // if(!empty($choseUser)){
                    $user = intval($ChoseUser);
                    // dd($user);
                    $userObj = $userRepo->find($user);
                    if($userObj != null){
                        $userId = $userObj->getId();
                        array_push($newUsers, $userId);
                    }

                    // }
                }
                $diffNew = array_diff( $newUsers, $oldUsers);
                $diffOld = array_diff( $oldUsers, $newUsers);
                $newUserToCreate = array_intersect($newUsers, $diffNew);
                $oldUserToDelete = array_intersect($oldUsers, $diffOld);
                //  dd($diff);
            if($newUsers != []){
                foreach($newUserToCreate as $newUser){
                    $apInformationviewed = new ApInformationViewed();
                    $apInformationviewed->setFile($apInformationFile);
                    $apInformationviewed->setUser($userRepo->find($newUser));
                    $apInformationViewedRepository->add($apInformationviewed);
                }
            }
            if($oldUserToDelete != []){

                foreach($oldUserToDelete as $oldUser){
                    $apInformationviewed = $apInformationViewedRepository->findByUserAndFile($userRepo->find($oldUser), $apInformationFile);
                    $apInformationViewedRepository->remove($apInformationviewed);
                }
            }
            // we delete all the old view in case nothing is selected

            
            if(isset($_POST['parapher']))
            {
                if($paraphers == []){
                    foreach($newUsers as $newUser){
                        $apInformationParapher = new ApInformationParapher();
                        $apInformationParapher->setFileId($apInformationFile);
                        $apInformationParapher->setUser($userRepo->find($newUser));
                        $apInformationParapherRepo->add($apInformationParapher);
                    }
                }else{
                    foreach($newUserToCreate as $newUser){
                        $apInformationParapher = new ApInformationParapher();
                        $apInformationParapher->setFileId($apInformationFile);
                        $apInformationParapher->setUser($userRepo->find($newUser));
                        $apInformationParapherRepo->add($apInformationParapher);
                    }
                }
                if($oldUserToDelete != []){
                    foreach($oldUserToDelete as $oldUser){
                        $apInformationParapher = $apInformationParapherRepo->findByUserAndFile($userRepo->find($oldUser), $apInformationFile);
                        $apInformationParapherRepo->remove($apInformationParapher);
                    }
                }
            }
            else{
                if($oldUsers != []){
                    foreach($oldUsers as $oldUser){
                        $apInformationParapher = $apInformationParapherRepo->findByUserAndFile($userRepo->find($oldUser), $apInformationFile);
                        if($apInformationParapher != null){
                            // dd($apInformationParapher);
                            $apInformationParapherRepo->remove($apInformationParapher);
                        }
                    }
                }    
            }
            if(isset($_POST['signature']))
            {
                if($signatures == []){
                    foreach($newUsers as $newUser){
                        $apInformationSignature = new ApInformationSignature();
                        $apInformationSignature->setFile($apInformationFile);
                        $apInformationSignature->setUser($userRepo->find($newUser));
                        $apInformationSignatureRepository->add($apInformationSignature);
                    }
                }else{
                    foreach($newUserToCreate as $newUser){
                        $apInformationSignature = new ApInformationSignature();
                        $apInformationSignature->setFile($apInformationFile);
                        $apInformationSignature->setUser($userRepo->find($newUser));
                        $apInformationSignatureRepository->add($apInformationSignature);
                    }
                }
                if($oldUserToDelete != []){
                    foreach($oldUserToDelete as $oldUser){
                        $apInformationSignature = $apInformationSignatureRepository->findByUserAndFile($userRepo->find($oldUser), $apInformationFile);
                         if($apInformationSignature != null){
                            $apInformationSignatureRepository->remove($apInformationSignature);
                         }
                    }
                }
            }
            else{
                if($oldUsers != []){
                    foreach($oldUsers as $oldUser){
                        $apInformationSignature = $apInformationSignatureRepository->findByUserAndFile($userRepo->find($oldUser), $apInformationFile);
                            if($apInformationSignature != null){
                                $apInformationSignatureRepository->remove($apInformationSignature);
                            }
                    }
                }
            }

            // if($newUser == []){

            // }


            #endregion target edit


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
            'state' => $state,
            'users' => $allUser,
            'oldUsers' => $oldUsers,
            'signatures' => $signatures,
            'paraphers' => $paraphers,
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

    /**
    * @route("/signature/{id}", methods={"GET"})
    */

    public function signature(Request $request,GlobalHistoryService $globalHistoryService, ApInformationSignatureRepository $apInformationSignatureRepo) : response
    {
        $submittedToken = $request->get('editCsrf');
        // 'search-item' is the same value used in the template to generate the token
        $signatureId = $request->get('id');
        $signature = $apInformationSignatureRepo->find($signatureId);
            if ($this->isCsrfTokenValid('edit-item', $submittedToken)) {
                $globalHistoryService->setInHistory($signature, 'read and approved');
                $signature->setState(1);
                $signature->setDateTime(new \DateTime());
                $apInformationSignatureRepo->add($signature);

            return $this->json(["code" => 200,
            "message" => "Lu et approuvé"], 200);
            }

    }

    /**
    * @route("/viewed/{id}", methods={"GET"})
    */

    public function viewed(Request $request,GlobalHistoryService $globalHistoryService, ApInformationViewedRepository $apInformationViewedRepo) : response
    {
        $submittedToken = $request->get('editCsrf');
        $viewedId = $request->get('id');
        $viewed = $apInformationViewedRepo->find($viewedId);
            if ($this->isCsrfTokenValid('edit-item', $submittedToken)) {
                $globalHistoryService->setInHistory($viewed, 'read and approved');
                $viewed->setState(1);
                $viewed->setDateTime(new \DateTime());
                $apInformationViewedRepo->add($viewed);

            return $this->json(["code" => 200,
            "message" => "Lu et approuvé"], 200);
            }

    }
}
