<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PsCustomerRepository;

class PsMapController extends AbstractController
{
    /**
     * @Route("/ps/map", name="ps_map")
     */
    public function index(): Response
    {
        return $this->render('ps_map/index.html.twig', [
            'controller_name' => 'PsMapController',
        ]);
    }

    /**
     * @Route("/ps/map/show", name="ps_customer_map", methods={"GET"})
     */
    public function leaflet(PsCustomerRepository $psCustomerRepository): Response
    {
        return $this->render('tabs/ps_map/google_chart.html.twig', [
            'ps_customer_repository' => $psCustomerRepository->findAll(),
        ]);
    }


}



// <?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use App\Repository\PsCustomerRepository;
//     /**
//      * @Route("/ps/customer/map", name="ps_customer_map", methods={"GET"})
//      */
//     public function leaflet(PsCustomerRepository $psCustomerRepository): Response
//     {
//         return $this->render('tabs/Catalog/VB/ap_catalog_case_vb/google_chart.html.twig', [
//             'ps_customer_repository' => $psCustomerRepository->findAll(),
//         ]);
//     }