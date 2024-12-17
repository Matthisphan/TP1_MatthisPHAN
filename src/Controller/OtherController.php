<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/category/{id}', name: 'page_category')]
    public function category(
        Category $category
    ): Response
    {
        return $this->render('other/category.html.twig', [
            'controller_name' => 'OtherController',
            'category' => $category,
        ]);
    }

    #[Route('/discover', name: 'page_discover')]
    public function discover(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    ): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('other/discover.html.twig', [
            'controller_name' => 'OtherController',
            'categories' => $categories,
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
