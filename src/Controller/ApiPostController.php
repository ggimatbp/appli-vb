<?php

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PsCustomerRepository;


class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index")
     */
    public function index(CallApiService $callApiService, PsCustomerRepository $psCustomerRepository): Response
    {       $postcode = [];
            $apiResultArray = [];
            $longitude = [];
            $latitude = [];
            // $allPsCustomer = $psCustomerRepository->findAll();
            //  foreach ($allPsCustomer as $value => $psCustomer )
            //  {
            //     if($psCustomer->getLatitude() === '6010'){
            //         $truePostCode = $psCustomer->getPostcode();
            //         array_push($postcode, $psCustomer->getPostcode());
            //         $apiResult = $callApiService->getFranceData($truePostCode);
            //         array_push($apiResultArray, $apiResult);
            //         foreach($apiResult['features'] as $key => $feature)
            //         {
            //             //if($key <= 1)
            //             //{
            //             $psCustomer->setLongitude($feature['geometry']['coordinates'][0]);
            //             $psCustomer->setLatitude($feature['geometry']['coordinates'][1]);
            //             $entityManager = $this->getDoctrine()->getManager();
            //             $entityManager->persist($psCustomer);
            //             $entityManager->flush();
            //            // }
            //         }
            //         // $psCustomer->setLongitude($resultat['features']['geometry']['coordinates'][0]);
            //         // $psCustomer->setLatitude($resultat['features']['geometry']['coordinates'][1]);
            //        // $long = $apiResult['features'][0]['geometry']['coordinates'][0];
            //        // $lat = $apiResult['features'][0]['geometry']['coordinates'][1];
            //        // array_push($longitude, $long);
            //        // array_push($latitude, $lat);
            //     }
            // }
            // $apiResult = $callApiService->getFranceData(6010);
            //$apiResult = $callApiService->getFranceData($postcode);
            return $this->render('api_post/index.html.twig', [
                'controller_name' => 'ApiPostController' ,
                //  'postcode' => $postcode, 'api' => $apiResultArray, 'psCustomer' => $psCustomer,
                //  'apiresult' => $apiResult['features'],
                //'longitude' => $longitude, 'latitude' => $latitude
            ]);
            
    }
}
