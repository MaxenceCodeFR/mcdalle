<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use App\Entity\Allergens;
use App\Repository\AllergensRepository;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingController extends AbstractController
{
    #[Route('/choose', name: 'landing')]
    public function index(ProductsRepository $productsRepository, AllergensRepository $allergensRepository, CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->find(1);
        $subcategories = $categoriesRepository->findBy(['parent_id' => 1]);


        return $this->render('landing/index.html.twig', compact('categories', 'subcategories'));
    }
}
