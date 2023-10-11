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

    #[Route('/choose/{id}', name: 'subcategory')]
    public function choose(Categories $categories): Response
    {

        $products = $categories->getProducts();

        return $this->render('landing/choose.html.twig', compact('products', 'categories'));
    }

    #[Route('/{id}', name: 'details')]
    public function details(Products $products): Response
    {



        $allergens = $products->getAllergens();

        return $this->render('landing/details.html.twig', compact('products', 'allergens'));
    }
}
