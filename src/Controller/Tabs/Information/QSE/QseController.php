<?php

namespace App\Controller\Tabs\Information\QSE;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationFilesRepository;
use App\Repository\ApInformationParentSectionRepository;
use App\Service\GlobalHistoryService;

/**
 * @Route("/information/qse", name="information_qse_")
 */

class QseController extends AbstractController
{
  public const TAB_NAME = "QSE";
   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationSectionRepository $sectionRepo, ApInformationFilesRepository $infoFileRepo, ApInformationParentSectionRepository $parentSectionRepo, GlobalHistoryService $globalHistoryService )
  {

    $tabName = self::TAB_NAME;
    $request = Request::createFromGlobals();
    $ipUser = $request->getClientIp();
    $globalHistoryService->setInHistory('view', 'information_qse_index', $ipUser, [$tabName]);
    $allSection = $sectionRepo->findAll();
    $allParentSection = $parentSectionRepo->findAll();
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    $user = $this->getUser();
    $accesses = $this->getUser()->getRoleId()->getApAccesses();
    
    foreach ($accesses as $access) {
      if($access->getTab()->getName() == $tabName ){
        if($access->getDelete() == false){
          $allFile = $infoFileRepo->findAllFilesByUserView($user);
        }elseif($access->getDelete() == true){
          $allFile = $infoFileRepo->findAll();
        }
      }
    }
    return $this->render('tabs/information/qse/index.html.twig', [
      'all_section' => $allSection,
      'all_file' => $allFile,
      'all_parent_section' => $allParentSection,
      'tabName' => $tabName,
      'actual_user' => $user,
  ]);
  }
}