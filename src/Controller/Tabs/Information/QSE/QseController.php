<?php

namespace App\Controller\Tabs\Information\QSE;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationFilesRepository;
use App\Repository\ApInformationParentSectionRepository;

/**
 * @Route("/information/qse", name="information_qse_")
 */

class QseController extends AbstractController
{
  public const TAB_NAME = "QSE";
   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationSectionRepository $sectionRepo, ApInformationFilesRepository $infoFileRepo, ApInformationParentSectionRepository $parentSectionRepo )
  {
    $tabName = self::TAB_NAME;
    $allSection = $sectionRepo->findAll();
    $allFile = $infoFileRepo->findAll();
    $allParentSection = $parentSectionRepo->findAll();
    // $tabName = self::TAB_NAME;
    return $this->render('tabs/information/qse/index.html.twig', [
      'all_section' => $allSection,
      'all_file' => $allFile,
      'all_parent_section' => $allParentSection,
      'tabName' => $tabName
  ]);
  }
}