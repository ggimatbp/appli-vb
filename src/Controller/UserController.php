<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\PasswordGenerator;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
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
    public function new(Request $request,  UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('plainPassword')->getData();
                // to do sécurity edit 
                 $user->setPassword(
                 $passwordEncoder->encodePassword(
                     $user,
                     $form->get('plainPassword')->getData()
                 )
             );
            $roleName = $user->getRoleId()->name;
            $user->setRoles($roleName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // if ($form->get('plainPassword')->getData()){
            //    // to do sécurity edit 
            //     $user->setPassword(
            //     $passwordEncoder->encodePassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );
            // } else {
            //     $user->getPassword();
            //     }
            $roleName = $user->getRoleId()->name;
            $user->setRoles($roleName);
            if($user->getActive() == false){
                $user->setNoRoles();
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

///////modifier mon mdp en ajax//////////
    /**
     * @route("/editPasswordOnClick/{id}", name="edit_name_onclick")
     */
   
    public function editPasswordOnClick(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager) : response
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
                $passwordEncoder->encodePassword($user,$userPassword)
                );
                $manager->flush();
                
                return $this->json(["code" => 200,
                "message" => "changer de mot de passe"], 200);
        }
    }
    
//////// générer mon mot de passe en ajax ////////
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
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('manager_index', [], Response::HTTP_SEE_OTHER);
    }
}
