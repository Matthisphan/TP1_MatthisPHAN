<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\MediaRepository;

class HomeController extends AbstractController
{
    public function __construct(
    )
    {
    }

    #[Route(path: '', name: 'page_home')]
    public function home(
        MediaRepository $mediaRepository,
    ): Response
    {
        $medias = $mediaRepository->findPopular(maxResults: 9);

        return $this->render(view: 'index.html.twig', parameters: [
            'medias' => $medias,
        ]);
    }
}