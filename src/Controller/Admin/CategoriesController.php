<?php

namespace App\Controller\Admin;

use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin-interface/categories', name: 'admin_interface_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findby([], ['category_order' => 'asc']);

        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }
}
