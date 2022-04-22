<?php

namespace App\Controller\Tabs\Information\RH;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApInformationSectionRepository;

/**
 * @Route("/information/rh", name="information_rh_")
 */

class RhController extends AbstractController
{


  public const TAB_NAME = "rh";

   /**
   * @Route("/", name="index")
   */
  public function index (ApInformationSectionRepository $sectionRepo)
  {
    $allSection = $sectionRepo->findAll();
    return $this->render('tabs/information/rh/index.html.twig', [
      'all_section' => $allSection
  ]);
  }
}