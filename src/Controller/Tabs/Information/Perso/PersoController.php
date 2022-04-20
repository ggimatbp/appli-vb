<?php

namespace App\Controller\Tabs\Information\Perso;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/information/perso", name="information_perso_")
 */

class PersoController extends AbstractController
{

  public const TAB_NAME = "perso";

   /**
   * @Route("/", name="index")
   */
  public function index ()
  {
    return $this->render('tabs/information/perso/index.html.twig');
  }
}