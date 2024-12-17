<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'page_admin')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin_add_films', name: 'page_admin_add_films')]
    public function admin_add(): Response
    {
        return $this->render('admin/admin_add_films.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin_films', name: 'page_admin_films')]
    public function admin_film(): Response
    {
        return $this->render('admin/admin_films.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin_users', name: 'page_admin_users')]
    public function admin_users(): Response
    {
        return $this->render('admin/admin_users.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
