<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'page_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/confirm', name: 'page_confirm')]
    public function index(): Response
    {
        return $this->render('auth/confirm.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/default', name: 'page_default')]
    public function default(): Response
    {
        return $this->render('auth/default.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/forgot', name: 'page_forgot')]
    public function forgot(): Response
    {
        return $this->render('auth/forgot.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/register', name: 'page_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/reset', name: 'page_reset')]
    public function reset(): Response
    {
        return $this->render('auth/reset.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/upload', name: 'page_upload')]
    public function upload(): Response
    {
        return $this->render('auth/upload.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
