<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ApAccessRepository;
use App\Repository\ApTabRepository;
use App\Repository\ApRoleRepository;
use App\Repository\ApEmployeeRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager", name="manager")
     */
    public function index(ApAccessRepository $apAccessRepository, ApRoleRepository $apRoleRepository, ApTabRepository $apTabRepository, ApEmployeeRepository $apEmployeeRepository, UserRepository $userRepository): Response
    {
        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
            'ap_accesses' => $apAccessRepository->findAll(), 
            'ap_roles' => $apRoleRepository->findAll(),
            'ap_tabs' => $apTabRepository->findAll(),
            'ap_employees' => $apEmployeeRepository->findAll(),
            'users' => $userRepository->findAll()
        ]);
    }

}
