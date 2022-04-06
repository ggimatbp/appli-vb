<?php

namespace App\Controller\Tabs\Manager;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\PasswordGenerator;
use Symfony\Component\Validator\Constraints\Length;
use App\Service\GlobalHistoryService;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    public const TAB_EMPLOYEE = "Employé";
    private $myglobalvar = 'user';
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordEncoder, GlobalHistoryService $globalHistoryService): Response
    {
        // à faire pour mettre de la sécurité en back 
        // $userId = $this->get('security.token_storage')->getToken()->getUser()->getRoleId()->getApAccesses();

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $tabNameEmployee = self::TAB_EMPLOYEE;

        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('plainPassword')->getData();
                // to do sécurity edit 
                 $user->setPassword(
                 $passwordEncoder->hashPassword(
                     $user,
                     $form->get('plainPassword')->getData()
                 )
             );
            $user->setTheme(0);
            $roleName = $user->getRoleId()->name;
            $user->setRoles($roleName);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $globalHistoryService->setInHistory($user, 'new');
            return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/manager/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'tabNameEmployee' => $tabNameEmployee,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        $tabNameEmployee = self::TAB_EMPLOYEE;
        return $this->render('tabs/manager/user/show.html.twig', [
            'user' => $user,
            'tabNameEmployee' => $tabNameEmployee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(ManagerRegistry $doctrine, Request $request, User $user, GlobalHistoryService $globalHistoryService): Response
    {
        $tabNameEmployee = self::TAB_EMPLOYEE;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roleName = $user->getRoleId()->name;
            $user->setRoles($roleName);
            if($user->getActive() == false){
                $user->setNoRoles();
            }
            $doctrine->getManager()->flush();
            $globalHistoryService->setInHistory($user, 'edit');
            return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/manager/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'tabNameEmployee' => $tabNameEmployee
        ]);
    }

//modifier mon mdp en ajax

    /**
     * @route("/editPasswordOnClick/{id}", name="edit_name_onclick")
     */
   
    public function editPasswordOnClick(Request $request, User $user,UserPasswordHasherInterface $passwordEncoder, ManagerRegistry $doctrine, GlobalHistoryService $globalHistoryService) : response
    {
        $userPassword = $request->get('task');
        $majuscule = preg_match('@[A-Z]@', $userPassword);
	    $minuscule = preg_match('@[a-z]@', $userPassword);
	    $chiffre = preg_match('@[0-9]@', $userPassword);
        if(!$majuscule && !$minuscule && !$chiffre || strlen($userPassword) < 12)
        { 
                return $this->json([], 404);
        }else{
            $user->setPassword(
                $passwordEncoder->hashPassword($user,$userPassword)
                );
                $doctrine->getManager()->flush();
                $globalHistoryService->setInHistory($user, 'edit password');
                return $this->json(["code" => 200,
                "message" => "changer de mot de passe"], 200);
        }
    }
    
//générer mon mot de passe en ajax

    /**
     * @Route("/password/generator", name="user_password_generator")
     */
    public function createRandomPasswordOnClick(PasswordGenerator $passwordGenerator)
    {
        
         return $this->json([$passwordGenerator->generateRandomStrongPassword(12)], 200);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete( ManagerRegistry $doctrine, Request $request, User $user, GlobalHistoryService $globalHistoryService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $globalHistoryService->setInHistory($user, 'delete');
            $entityManager = $doctrine->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

        }

        return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
    }
}
