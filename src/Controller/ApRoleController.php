<?php

namespace App\Controller;



use App\Entity\ApRole;
use App\Entity\ApAccess;
use App\Entity\ApTab;
use App\Form\ApRoleType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ApRoleRepository;
use App\Repository\ApAccessRepository;
use App\Repository\ApTabRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/ap/role")
 */
class ApRoleController extends AbstractController
{

    const BASIC_ROLE = 43;

    /**
     * @Route("/", name="ap_role_index", methods={"GET"})
     */
    public function index(ApRoleRepository $apRoleRepository): Response
    {
        return $this->render('ap_role/index.html.twig', [
            'ap_roles' => $apRoleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_role_new", methods={"GET","POST"})
     */
    public function new(Request $request, ApTabRepository $apTabRepository): Response
    {
        $apRole = new ApRole();

        $form = $this->createForm(ApRoleType::class, $apRole);
        $form->handleRequest($request);
        // if ($this->isCsrfTokenValid('delete'.$apRole->getApAccesses(), $request->request->get('_token'))) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->remove($apRole->getApAccesses());
        //     $entityManager->flush();
        // }



        if ($form->isSubmitted() && $form->isValid()) {

            // foreach($apTabRepository as );
            //if submit we create all access 
            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apRole);
            $bob = $apTabRepository->findAllId(); 
            //    var_dump($bob);
                foreach($bob as $tab){
                    $apAccess = new ApAccess;
                    $apAccess->setTab($tab);
                    $apAccess->setRole($apRole);
                    $apAccess->setView(0);
                    $apAccess->setAdd(0);
                    $apAccess->setEdit(0);
                    $apAccess->setDelete(0);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($apAccess);
                };

            $entityManager->flush();
                $id = $apRole->getId();
            // return $this->redirectToRoute('ap_role_index', [], Response::HTTP_SEE_OTHER);
           // return $this->redirect('http://symfony.com/doc');
           return $this->redirect('/ap/role/' . $id . '/edit');
        }

        return $this->renderForm('ap_role/new.html.twig', [
            'ap_role' => $apRole,
            'form' => $form,
            'tabs' => $apTabRepository->findAll(),
        ]);
    }




    /**
     * @Route("/show/{id}", name="ap_role_show", methods={"GET"})
     */
    public function show(ApRole $apRole): Response
    {
        return $this->render('ap_role/show.html.twig', [
            'ap_role' => $apRole,
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="ap_role_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, ApRole $apRole): Response
    // {
        
    //     $editForm = $this->createForm(ApRoleType::class, $apRole);
    //     $editForm->handleRequest($request);

    //     if ($editForm->isSubmitted() && $editForm->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('ap_role_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('ap_role/edit.html.twig', [
    //         'ap_role' => $apRole,
    //         'form' => $editForm,
    //     ]);
    // }





    /**
     * @Route("/{id}/edit", name="ap_role_edit", methods={"GET","POST"})
     */
    public function edit($id, ApRole $apRole, EntityManagerInterface $entityManager): Response
    {

        //  if(empty($apRole)){
        //      throw $this->createNotFoundException('Pas de role trouvé pour' .$id);
        //  }

         if (null === $apRole = $entityManager->getRepository(ApRole::class)->find($id)) {
            throw $this->createNotFoundException('No task found for id '.$id);
        }

        $originalaccesses = new ArrayCollection();

        foreach ($apRole->getApAccesses() as $apaccess) 
        {
            $originalaccesses->add($apaccess);
        }

        // $editForm = $this->createForm(ApRoleType::class, $apRole);
        // $editForm->handleRequest($request);

        // if ($editForm->isSubmitted() && $editForm->isValid()) {

            // foreach($originalaccesses as $access)
            // {
            //     if (false === $apRole->getApAccesses()->contains($access)){

                    
            //          $access->setApAccesses(null);
            //          $entityManager->persist($access);
            //     }
            // }  
        

        //     $this->getDoctrine()->getManager()->flush();

        //     return $this->redirectToRoute('ap_role_index', [], Response::HTTP_SEE_OTHER);
        // }

        return $this->renderForm('ap_role/edit.html.twig', [
            'ap_role' => $apRole,
            // 'form' => $editForm,
        ]);
    }




    /**
     * @Route("/delete/{id}", name="ap_role_delete", methods={"POST"})
     */
    public function delete(Request $request, ApRole $apRole, UserRepository $userRepository, ApRoleRepository $apRoleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apRole->getId(), $request->request->get('_token'))) {

            //We took all the users who got the role who's gonna be deleted
            $userArray = $userRepository->getUsersByRole($apRole->getId());
            //we took the role object we want to exchange by  the role who's gonna be deleted
            $lambdaRole = $apRoleRepository->find(self::BASIC_ROLE);
            //we set the role for all users
            foreach ($userArray as $user){
                $user->setRoleId($lambdaRole);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apRole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @route("/editName/{id}", methods={"GET"})
    */

    public function editotest(Request $request, ApRole $apRole, EntityManagerInterface $manager) : response
    {

        $roleName = $request->get('task');
         $apRole->setName($roleName);
         $manager->flush();
       return $this->json(["code" => 200,
       "message" => "changer nom"], 200);
    }

}
