<?php

namespace App\Controller\Tabs\Manager;

use App\Entity\ApAccess;
use App\Form\ApAccessType;
use App\Repository\ApAccessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\GlobalHistoryService;

/**
 * @Route("/ap/access")
 */
class ApAccessController extends AbstractController
{  
    
    /**
     * @route("/addAuthOnClick/{id}", name="add_auth_on_click")
     */
    
    public function addAuthOnClick(Request $request, ApAccess $apAccess, ManagerRegistry $doctrine, GlobalHistoryService $globalHistoryService) : response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $submittedToken = $request->get('editAccessCsrf');
        $manager = $doctrine->getManager();
        $roleName = $apAccess->getRole()->getName();
        if(!($roleName == "ADMIN")){
            if ($this->isCsrfTokenValid('edit-item', $submittedToken)){
                if($apAccess->getAdd() == 1)
                {
                    $globalHistoryService->setInHistory($apAccess, 'Add edit unauth', $ipUser);
                    $apAccess->setAdd(0);
                    $manager->flush();
                }
                else
                {
                    $globalHistoryService->setInHistory($apAccess, 'Add edit auth', $ipUser);
                    $apAccess->setAdd(1);
                    $manager->flush();
                }
                return $this->json(["code" => 200,
                "message" => "access add",
                "status" => $apAccess->getAdd()], 200);
            }
        }

    }

    /**
     * @route("/deleteAuthOnClick/{id}", name="delete_auth_on_click")
     */
    
    public function DeleteAuthOnClick(Request $request, ApAccess $apAccess, ManagerRegistry $doctrine, GlobalHistoryService $globalHistoryService) : response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $submittedToken = $request->get('editAccessCsrf');
        $manager = $doctrine->getManager();
        $roleName = $apAccess->getRole()->getName();
        if(!($roleName == "ADMIN")){
            if ($this->isCsrfTokenValid('edit-item', $submittedToken)){
                if($apAccess->getDelete() == 1)
                {
                    $globalHistoryService->setInHistory($apAccess, 'Delete edit unauth', $ipUser);
                    $apAccess->setDelete(0);
                    $manager->flush();
                }
                else
                {
                    $globalHistoryService->setInHistory($apAccess, 'delete edit auth', $ipUser);
                    $apAccess->setDelete(1);
                    $manager->flush();
                }
                return $this->json(["code" => 200,
                "message" => "access delete",
                "status" => $apAccess->getDelete()], 200);
            }
        }   
    }


    /**
     * @route("/editAuthOnClick/{id}", name="edit_auth_on_click")
    */

    public function editAuthOnClick(Request $request, ApAccess $apAccess, ManagerRegistry $doctrine, GlobalHistoryService $globalHistoryService) : response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();

        $submittedToken = $request->get('editAccessCsrf');
        $manager = $doctrine->getManager();
        $roleName = $apAccess->getRole()->getName();
        if(!($roleName == "ADMIN")){
            if ($this->isCsrfTokenValid('edit-item', $submittedToken))
            {
                if($apAccess->getEdit() == 1)
                {
                    $globalHistoryService->setInHistory($apAccess, 'edition edit unauth', $ipUser);
                    $apAccess->setEdit(0);
                    $manager->flush();
                }
                else
                {
                    $globalHistoryService->setInHistory($apAccess, 'edition edit unauth', $ipUser);
                    $apAccess->setEdit(1);
                    $manager->flush();
                }
                return $this->json(["code" => 200,
                "message" => "access Edit",
                "status" => $apAccess->getEdit()],
                200);
            }
        }
    }

    /**
     * @route("/viewAuthOnClick/{id}", name="view_auth_on_click")
    */

    public function viewAuthOnClick(Request $request, ApAccess $apAccess, ManagerRegistry $doctrine, GlobalHistoryService $globalHistoryService) : response
    {
        $submittedToken = $request->get('editAccessCsrf');
        $manager = $doctrine->getManager();
        $roleName = $apAccess->getRole()->getName();
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();
        if(!($roleName == "ADMIN")){
            if ($this->isCsrfTokenValid('edit-item', $submittedToken)){
                if($apAccess->getView() == 1)
                {
                    $globalHistoryService->setInHistory($apAccess, 'view edit unauth', $ipUser);
                    $apAccess->setView(0);
                    $manager->flush();
                }
                else
                {
                    $globalHistoryService->setInHistory($apAccess, 'view edit unauth', $ipUser);
                    $apAccess->setView(1);
                    $manager->flush();
                }
                return $this->json(["code" => 200,
                "message" => "access View",
                "status" => $apAccess->getView()], 200);
            }
        }
    }
}
