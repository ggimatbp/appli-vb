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
    

        $ap_accesses = $apAccessRepository->findAll();
        // $ap_roles = $apRoleRepository->findAll();
        $ap_tabs = $apTabRepository->findAll();
        
        $controller_name = 'ManagerController';
        
        //On récupére le nombre total d'annonces
       // $total = $userRepository->getTotalUsers();

        //On définit le nombre d'élément par page

         $limit = $request->query->get("limit", 2);

        //On récupère le numéro de page
        // $page = (int)$request->query->get("page", 1);

        $limitRole = $request->query->get("limitRole", 2);

        $pageRole = (int)$request->query->get("pageRole", 2);


        
        // Session for employee 

        $filterLimitSession = $session->get("filterLimit", []);
        $filterSession = $session->get("filter", []);


        //Session for Role 

        $roleFilterSession = $session->get("roleFilter", []);


        // Déclarer et ou reprendre les données de la session pour employee

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

        // Déclarer et ou reprendre les données de la session pour role //

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

          
        //On verifie si on a une requète ajax pour employee
        if($request->get('ajax')){
            // $ap_roles = $apRoleRepository->findRoleByFilterField($limitRole, $pageRole);
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

            $total = $userRepository->getTotalUsersAfterFilters($ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId);

            if($page > ceil($total/$limit))
            {
                $page = ceil($total/$limit); 
            }
            if($page < 1)
            {
                $page = 1;
            }

            $users = $userRepository->findUserByfilterField($limit, $page, $ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId, $ajaxOrder, $ajaxFilterNameOrder);

            $filterSession = $session->set('filter', ['limit' => $limit, 'page' => $page, 'ajaxActive'  => $ajaxActive, 'ajaxRoleId'=>  $ajaxRoleId, 'ajaxRoleName'=>$ajaxRoleName, 'ajaxEmail' => $ajaxEmail, 'ajaxFirstname' => $ajaxFirstname, 'ajaxLastname' => $ajaxLastname, 'ajaxId' => $ajaxId, 'ajaxOrder' => $ajaxOrder, 'ajaxFilterNameOrder' => $ajaxFilterNameOrder]);

            return new JsonResponse([
                'content' => $this->renderView('manager/_filtredEmployee.html.twig', compact('ap_accesses', 'ap_tabs', 'users', 'controller_name', 'total', 'limit', 'page', 'session', 'filterSession')),
                'content2' =>$this->renderView('manager/_paginationEmployee.html.twig', compact('ap_accesses', 'ap_tabs', 'users', 'controller_name', 'total', 'limit', 'page', 'filterSession')),
            ]);
        }
        elseif($request->get('ajax1')){

            // $rolefilterSession = $session->set('roleFilter', ['pageRole' => $pageRole, 'limitRole'  => $limitRole, 'ajaxFilterRoleName'=>  $ajaxFilterRoleName, 'ajaxRoleOrder'=>$ajaxRoleOrder]);

            $limitRole = $request->get('ajaxRoleLimit');

            $pageRole = $request->get('ajaxRolePage');

            $ajaxFilterRoleName = $request->get('ajaxFilterRoleName');
            
            $ajaxRoleOrder = $request->get('ajaxRoleOrder');

            //total des roles apres filtre
            $totalRole = $apRoleRepository->getTotalRoleAfterFilter($ajaxFilterRoleName, $ajaxRoleOrder);

            if($pageRole > ceil($totalRole/$limitRole))
            {
                $pageRole = ceil($totalRole/$limitRole); 
            }
            if($pageRole < 1)
            {
                $pageRole = 1;
            }

            $roleFilterSession = $session->set('roleFilter', ['limitRole' => $limitRole, 'pageRole' => $pageRole, 'ajaxFilterRoleName'  => $ajaxFilterRoleName, 'ajaxRoleOrder'=>  $ajaxRoleOrder]);

             $ap_roles = $apRoleRepository->findRoleByFilterField($limitRole, $pageRole, $ajaxFilterRoleName, $ajaxRoleOrder);
            //  $total = $userRepository->getTotalUsersAfterFilters($ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId);
            //  $users = $userRepository->findUserByfilterField($limit, $page, $ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId, $ajaxOrder, $ajaxFilterNameOrder);
            
           return new JsonResponse([
            'content' => $this->renderView('manager/_filteredRoleAndAccess.html.twig', compact('ap_accesses','ap_roles', 'ap_tabs', 'controller_name', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession')),
            'content2' => $this->renderView('manager/_paginationRoleAndAccess.html.twig', compact('ap_accesses','ap_roles', 'ap_tabs', 'controller_name', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession'))
        ]);
        }
        else{
            $totalRole = $apRoleRepository->getTotalRoleAfterFilter($ajaxFilterRoleName, $ajaxRoleOrder);
            $ap_roles = $apRoleRepository->findRoleByFilterField($limitRole, $pageRole, $ajaxFilterRoleName, $ajaxRoleOrder);
            $total = $userRepository->getTotalUsersAfterFilters($ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId);
            $users = $userRepository->findUserByfilterField($limit, $page, $ajaxActive, $ajaxRoleId, $ajaxEmail, $ajaxFirstname, $ajaxLastname, $ajaxId, $ajaxOrder, $ajaxFilterNameOrder);
        }

        //For the dropdown role name filter
        $allRole = $apRoleRepository->findAll();

        return $this->render('manager/index.html.twig', compact('ap_accesses','ap_roles', 'ap_tabs', 'users', 'controller_name', 'total', 'limit', 'page', 'session', 'filterSession', 'limitRole', 'pageRole', 'totalRole', 'roleFilterSession', 'allRole'));
    }

    #endregion
    /**
     * @Route("/filter_pagination", name="_filter_pagination")
     */

     public function filters_pagination(UserRepository $userRepository, Request $request)
    { 

        //On récupére le nombre total d'annonces
        $total = $userRepository->getTotalUsers();


        //On définit le nombre d'élément par page
        $limit = $request->query->get("limit", 2);;

        //On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);
        

        if($_POST)
        {
            
            if(!empty($_POST['pageNumber']))
            {
                $page = $_POST['pageNumber'];
            }
            if($_POST['pageNumber'] > ceil($total/$limit))
            {
                $page = ceil($total/$limit); 
            }
            if($_POST['pageNumber'] < $total/$limit)
            {
                $page = 1;
            }
        }

        if($_GET)
        {     
            if(!empty($_GET['pageLimitNumber']))  
            {
                $limit = ($_GET['pageLimitNumber']);  
            }  
        }
                //On récupére les annonces de la pages        
                $users = $userRepository->getPaginatedUsers($page, $limit);
        
        return $this->render('user/index.html.twig', compact('users', 'total', 'limit', 'page'));
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
