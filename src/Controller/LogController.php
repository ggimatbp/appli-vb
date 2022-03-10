<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{

    // private $dbLogger;

    // public function __construct(LoggerInterface $dbLogger)
    // {
    //     $this->dbLogger = $dbLogger;
    // }


    /**
     * @Route("/log", name="log")
     */
    public function index(LoggerInterface $dbLogger): Response
    {
        $dbLogger->info('123456789');
        return $this->render('log/index.html.twig', [
            'controller_name' => 'LogController'
        ]);
    }
}
