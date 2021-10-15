<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use App\Repository\ApTabRepository;
use App\Repository\ApRoleRepository;
use App\Repository\ApAccessRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/manager", name="manager_")
 */

class ManagerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ApAccessRepository $apAccessRepository, ApRoleRepository $apRoleRepository, ApTabRepository $apTabRepository, UserRepository $userRepository): Response
    {

        $ap_accesses = $apAccessRepository->findAll();
        $ap_roles = $apRoleRepository->findAll();
        $ap_tabs = $apTabRepository->findAll();
        
        $controller_name = 'ManagerController';

        //On verifie si on a une requète ajax

        if($request->get('ajax')){

            $ajaxActive = $request->get('ajaxActive');

            $ajaxRoleId = $request->get('ajaxRoleId');

            $ajaxEmail = $request->get('ajaxEmail');

            $ajaxFirstname = $request->get('ajaxFirstname');

            $ajaxLastname = $request->get('ajaxLastname');

            $ajaxId = $request->get('ajaxId');

            $users = $userRepository->findUserByfilterField($ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId);


            return new JsonResponse([
                'content' => $this->renderView('manager/_filtredEmployee.html.twig', compact('ap_accesses','ap_roles', 'ap_tabs', 'users', 'controller_name'))
            ]);
        }
        else{
            $users = $userRepository->findUserByfilterField();
        }
        return $this->render('manager/index.html.twig', compact('ap_accesses','ap_roles', 'ap_tabs', 'users', 'controller_name'));
    }

    /**
     * @Route("/filter", name="_filter")
     */

     public function filters_employee(UserRepository $userRepository): string
    {
        //  $active = $request->get('task');
        //  $userFilered = $userRepository->findUserByfilterField();
        // $user1 = $userRepository->find(1);
        // $user2 = json_encode($user1);
        // return $user2;
        return 'oups';
    } 

}


// public function index(ApAccessRepository $apAccessRepository, ApRoleRepository $apRoleRepository, ApTabRepository $apTabRepository, UserRepository $userRepository): Response
// {

//     $ap_accesses = $apAccessRepository->findAll();
//     $ap_roles = $apRoleRepository->findAll();
//     $ap_tabs = $apTabRepository->findAll();
//     $users = $userRepository->findAll();
//     $controller_name = 'ManagerController';

//     return $this->render('manager/index.html.twig', [
//         'controller_name' => 'ManagerController',
//         'ap_accesses' => $apAccessRepository->findAll(), 
//         'ap_roles' => $apRoleRepository->findAll(),
//         'ap_tabs' => $apTabRepository->findAll(),
//         'users' => $userRepository->findAll()
//     ]);
// }
