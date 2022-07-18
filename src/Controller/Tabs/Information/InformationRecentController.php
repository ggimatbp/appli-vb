<?php

namespace App\Controller\Tabs\Information;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationFilesRepository;
use App\Service\GlobalHistoryService;


/**
 * @Route("/information", name="information_")
 */

class InformationRecentController extends AbstractController
{

  public const TAB_NAME_RH = "RH";
  public const TAB_NAME_QSE = "QSE";

   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationFilesRepository $apInformationFilesRepository, GlobalHistoryService $globalHistoryService): Response
  {

    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    $user = $this->getUser();
    // $accesses = $this->getUser()->getRoleId()->getApAccesses();
    $tabNameRh = self::TAB_NAME_RH;
    $tabNameQse = self::TAB_NAME_QSE;

    $request = Request::createFromGlobals();
    $ipUser = $request->getClientIp();
    $globalHistoryService->setInHistory('view', 'information_section_index', $ipUser);

    $recentRhFiles = $apInformationFilesRepository->findRecentRhFilesByUserView($user);
    $recentQseFiles = $apInformationFilesRepository->findRecentQseFilesByUserView($user);
    $lastRhFile = $apInformationFilesRepository->findLastRhFilesByUserView($user);
    $lastQseFile = $apInformationFilesRepository->findLastQseFilesByUserView($user);


    

    return $this->render('tabs/information/index.html.twig', [
      'rh_files' => $recentRhFiles,
      'qse_files' => $recentQseFiles,
      'rh_file' => $lastRhFile,
      'qse_file' => $lastQseFile,
      'tabNameRh' => $tabNameRh,
      'tabNameQse' => $tabNameQse,
      'actual_user' => $user,
  ]);
  }
}