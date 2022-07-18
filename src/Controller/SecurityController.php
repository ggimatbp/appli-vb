<?php

namespace App\Controller;

use App\Service\GlobalHistoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, GlobalHistoryService $globalHistoryService): Response
    {
        $request = Request::createFromGlobals();
        $ipUser = $request->getClientIp();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // we put the failed login attempt here
        $extra = [$error, $lastUsername];
        $globalHistoryService->setInHistory('login failed', 'login failed', $ipUser, $extra);
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/", name="app_bis_login")
     */
    public function loginBis(): Response
    {
        return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
        //return $this->render('security/login2.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }


}
