<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/", name="home")
     */
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('home/index.html.twig');
    }
}