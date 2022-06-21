<?php

namespace App\Controller\Tabs\Information\RH;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationFilesRepository;
use App\Repository\ApInformationParentSectionRepository;

/**
 * @Route("/information/rh", name="information_rh_")
 */

class RhController extends AbstractController
{


  public const TAB_NAME = "RH";

   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationSectionRepository $sectionRepo, ApInformationFilesRepository $infoFileRepo, ApInformationParentSectionRepository $parentSectionRepo)
  {
    $tabName = self::TAB_NAME;
    $allSection = $sectionRepo->findAll();
    $allFile = $infoFileRepo->findAll();
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
    return $this->render('tabs/information/rh/index.html.twig', [
      'all_section' => $allSection,
      'all_file' => $allFile,
      'all_parent_section' => $allParentSection,
      'tabName' => $tabName
  ]);
  }
}