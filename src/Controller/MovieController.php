<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie_detail', name: 'page_movie_detail')]
    public function movie_detail(): Response
    {
        return $this->render('movie/detail.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/movie_detail_serie', name: 'page_movie_detail_serie')]
    public function movie_detail_serie(): Response
    {
        return $this->render('movie/detail_serie.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }
}
