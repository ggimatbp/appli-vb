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
use Symfony\Component\HttpFoundation\Session\SessionInterface;



/**
 * @Route("/manager", name="manager_")
 */

class ManagerController extends AbstractController
{	
#region function index
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, Request $request, ApAccessRepository $apAccessRepository, ApRoleRepository $apRoleRepository, ApTabRepository $apTabRepository, UserRepository $userRepository): Response
    {
    #region Session and pagination
        #region declare
        $ap_accesses = $apAccessRepository->findAll();

        //declare element's number by page
         $limit = $request->query->get("limit", 2);

        $limitRole = $request->query->get("limitRole", 2);

        //get page number
        $pageRole = (int)$request->query->get("pageRole", 2);
    
        // Session for employee 
        $filterSession = $session->get("filter", []);


        //Session for Role 
        $roleFilterSession = $session->get("roleFilter", []);

        #region employee: declare or get data session
        if  (isset($filterSession['limit'])) {
             $limit  = $filterSession['limit'];
        } 
        
         if  (isset($filterSession['page'])) {

            $page  = $filterSession['page'];
         }else{
            $page = 1;
         }

         if  (isset($filterSession['ajaxActive'])) {

            $ajaxActive  = $filterSession['ajaxActive'];
         }else{
            $ajaxActive = null;
         } 

         if  (isset($filterSession['ajaxRoleId'])) {

            $ajaxRoleId  = $filterSession['ajaxRoleId'];
         }else{
            $ajaxRoleId  = null;
         }

         if  (isset($filterSession['ajaxEmail'])) {

            $ajaxEmail  = $filterSession['ajaxEmail'];
         }else{
            $ajaxEmail  = null;
         }

         if  (isset($filterSession['ajaxFirstname'])) {

            $ajaxFirstname  = $filterSession['ajaxFirstname'];
         }else{
            $ajaxFirstname  = null;
         }

         if  (isset($filterSession['ajaxLastname'])) {

            $ajaxLastname  = $filterSession['ajaxLastname'];
         }else{
            $ajaxLastname  = null;
         }
        
        if  (isset($filterSession['ajaxId'])) {

            $ajaxId  = $filterSession['ajaxId'];
        }else{
            $ajaxId  = null;
        }

        if  (isset($filterSession['ajaxOrder'])) {

            $ajaxOrder  = $filterSession['ajaxOrder'];
        }else{
            $ajaxOrder  = null;
        }

        if  (isset($filterSession['ajaxFilterNameOrder'])) {

            $ajaxFilterNameOrder = $filterSession['ajaxFilterNameOrder'];
        }else{
            $ajaxFilterNameOrder = null;
        }
        #endregion employee: declare or get data session

        #region Role: declare or get data session
        if  (isset($roleFilterSession['limitRole'])) {

            $limitRole = $roleFilterSession['limitRole'];
        }

        if (isset($roleFilterSession['ajaxFilterRoleName'])){
            $ajaxFilterRoleName = $roleFilterSession['ajaxFilterRoleName'];
        }else{
            $ajaxFilterRoleName = null;
        }

        if (isset($roleFilterSession['ajaxRoleOrder'])){
            $ajaxRoleOrder = $roleFilterSession['ajaxFilterRoleName'];
        }else{
            $ajaxRoleOrder = null;
        }

        if  (isset($roleFilterSession['pageRole'])) {

            $pageRole  = $roleFilterSession['pageRole'];
         }else{
            $pageRole = 1;
         }
        #endregion Role: declare or get data session
    #endregion session and pagination  

    #region Employee if Ajax
        if($request->get('ajax')){
            //get all ajax value from apmanager.js and declare them
            $ajaxOrder = $request->get('ajaxOrder');

            $ajaxFilterNameOrder = $request->get('ajaxFilterNameOrder');

            $ajaxActive = $request->get('ajaxActive');

            $ajaxRoleId = $request->get('ajaxRoleId');

            $ajaxRoleName = $request->get('ajaxRoleName');

            $ajaxEmail = $request->get('ajaxEmail');

            $ajaxFirstname = $request->get('ajaxFirstname');

            $ajaxLastname = $request->get('ajaxLastname');

            $ajaxId = $request->get('ajaxId');

            $limit = $request->get('ajaxLimit');

            $page = $request->get('ajaxPage');

            //create a new total related to ajax new filter info for pagination
            $total = $userRepository->getTotalUsersAfterFilters($ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId);

            if($page > ceil($total/$limit))
            {
                $page = ceil($total/$limit); 
            }
            if($page < 1)
            {
                $page = 1;
            }

            //get user's results in database related to ajax filter
            $users = $userRepository->findUserByfilterField($limit, $page, $ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId, $ajaxOrder, $ajaxFilterNameOrder);

            //Put all ajax filter in Session
            $filterSession = $session->set('filter', ['limit' => $limit, 'page' => $page, 'ajaxActive'  => $ajaxActive, 'ajaxRoleId'=>  $ajaxRoleId, 'ajaxRoleName'=>$ajaxRoleName, 'ajaxEmail' => $ajaxEmail, 'ajaxFirstname' => $ajaxFirstname, 'ajaxLastname' => $ajaxLastname, 'ajaxId' => $ajaxId, 'ajaxOrder' => $ajaxOrder, 'ajaxFilterNameOrder' => $ajaxFilterNameOrder]);

            //Return only new result of employee and pagination
            return new JsonResponse([
                'content' => $this->renderView('manager/_filtredEmployee.html.twig', compact('ap_accesses', 'users', 'total', 'limit', 'page', 'session', 'filterSession')),
                'content2' =>$this->renderView('manager/_paginationEmployee.html.twig', compact('ap_accesses', 'users', 'total', 'limit', 'page', 'filterSession')),
            ]);
        }
        #endregion Employee if Ajax

        #region Role if Ajax1
        elseif($request->get('ajax1')){
            //get all ajax value from apmanager.js and declare them
            $limitRole = $request->get('ajaxRoleLimit');

            $pageRole = $request->get('ajaxRolePage');

            $ajaxFilterRoleName = $request->get('ajaxFilterRoleName');
            
            $ajaxRoleOrder = $request->get('ajaxRoleOrder');

            //create a new total related to ajax new filter info for pagination
            $totalRole = $apRoleRepository->getTotalRoleAfterFilter($ajaxFilterRoleName, $ajaxRoleOrder);

            if($pageRole > ceil($totalRole/$limitRole))
            {
                $pageRole = ceil($totalRole/$limitRole); 
            }
            if($pageRole < 1)
            {
                $pageRole = 1;
            }

            //Put all ajax filter in Session
            $roleFilterSession = $session->set('roleFilter', ['limitRole' => $limitRole, 'pageRole' => $pageRole, 'ajaxFilterRoleName'  => $ajaxFilterRoleName, 'ajaxRoleOrder'=>  $ajaxRoleOrder]);

            //get role's results in database related to ajax filter
            $ap_roles = $apRoleRepository->findRoleByFilterField($limitRole, $pageRole, $ajaxFilterRoleName, $ajaxRoleOrder);

            //Return only new result of role and pagination 
            return new JsonResponse([
            'content' => $this->renderView('manager/_filteredRoleAndAccess.html.twig', compact('ap_accesses','ap_roles', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession')),
            'content2' => $this->renderView('manager/_paginationRoleAndAccess.html.twig', compact('ap_accesses','ap_roles', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession'))
            ]);
        }
        #endregion Role if Ajax

        #region If no Ajax
        else{
            //get all role and user or related to the one save in session
            $totalRole = $apRoleRepository->getTotalRoleAfterFilter($ajaxFilterRoleName, $ajaxRoleOrder);
            $ap_roles = $apRoleRepository->findRoleByFilterField($limitRole, $pageRole, $ajaxFilterRoleName, $ajaxRoleOrder);
            $total = $userRepository->getTotalUsersAfterFilters($ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId);
            $users = $userRepository->findUserByfilterField($limit, $page, $ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId, $ajaxOrder, $ajaxFilterNameOrder);
        }

        //For the dropdown role name filter
        $allRole = $apRoleRepository->findAll();

        return $this->render('manager/index.html.twig', compact('ap_accesses','ap_roles', 'users', 'total', 'limit', 'page', 'session', 'filterSession', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession', 'allRole'));
        #endregion If no Ajax
    }

    #endregion index

}
