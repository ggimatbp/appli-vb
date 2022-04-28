<?php

namespace App\Controller\Tabs\Information\QSE;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationFilesRepository;

/**
 * @Route("/information/qse", name="information_qse_")
 */

class QseController extends AbstractController
{
  public const TAB_NAME = "qse";
   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationSectionRepository $sectionRepo, ApInformationFilesRepository $infoFileRepo )
  {
    $allSection = $sectionRepo->findAll();
    $allFile = $infoFileRepo->findAll();
    // $tabName = self::TAB_NAME;
    return $this->render('tabs/information/qse/index.html.twig', [
      'all_section' => $allSection,
      'all_file' => $allFile
  ]);
  }
}