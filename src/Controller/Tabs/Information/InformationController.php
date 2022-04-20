<?php

namespace App\Controller\Tabs\Information;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/information", name="information_")
 */

class InformationController extends AbstractController
{

   /**
   * @Route("/", name="index")
   */
  public function index ()
  {
    return $this->render('tabs/information/index.html.twig');
  }
}