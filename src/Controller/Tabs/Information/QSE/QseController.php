<?php

namespace App\Controller\Tabs\Information\QSE;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/information/qse", name="information_qse_")
 */

class QseController extends AbstractController
{
  public const TAB_NAME = "qse";
   /**
   * @Route("/", name="index")
   */
  public function index ()
  {
    // $tabName = self::TAB_NAME;
    return $this->render('tabs/information/qse/index.html.twig', [
  ]);
  }
}