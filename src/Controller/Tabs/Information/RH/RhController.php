<?php

namespace App\Controller\Tabs\Information\RH;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationSectionRepository;
use App\Repository\ApInformationFilesRepository;

/**
 * @Route("/information/rh", name="information_rh_")
 */

class RhController extends AbstractController
{


  public const TAB_NAME = "rh";

   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationSectionRepository $sectionRepo, ApInformationFilesRepository $infoFileRepo)
  {
    $allSection = $sectionRepo->findAll();
    $allFile = $infoFileRepo->findAll();
    return $this->render('tabs/information/rh/index.html.twig', [
      'all_section' => $allSection,
      'all_file' => $allFile
  ]);
  }
}