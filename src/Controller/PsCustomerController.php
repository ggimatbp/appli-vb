<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PsCustomerRepository;
use App\Entity\PsCustomer;


class PsCustomerController extends AbstractController
{
    /**
     * @Route("/ps/customer", name="ps_customer")
     */
    public function index(): Response
    {
        return $this->render('ps_customer/index.html.twig', [
            'controller_name' => 'PsCustomerController',
        ]);
    }


    /**
     * @Route("/ps/customer/map", name="ps_customer_map", methods={"GET"})
     */
    public function leaflet(PsCustomerRepository $psCustomerRepository): Response
    {
        return $this->render('tabs/Catalog/VB/ap_catalog_case_vb/google_chart.html.twig', [
            'ps_customer_repository' => $psCustomerRepository->findAll(),
        ]);
    }
}
