<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OtherController extends AbstractController
{
    #[Route('/abonnements', name: 'page_abonnements')]
    public function abonnements(): Response
    {
        return $this->render('other/abonnements.html.twig', [
            'controller_name' => 'OtherController',
        ]);
    }

    #[Route('/category', name: 'page_category')]
    public function category(): Response
    {
        return $this->render('other/category.html.twig', [
            'controller_name' => 'OtherController',
        ]);
    }

    #[Route('/discover', name: 'page_discover')]
    public function discover(): Response
    {
        return $this->render('other/discover.html.twig', [
            'controller_name' => 'OtherController',
        ]);
    }

    #[Route('/lists', name: 'page_lists')]
    public function lists(): Response
    {
        return $this->render('other/lists.html.twig', [
            'controller_name' => 'OtherController',
        ]);
    }
}
