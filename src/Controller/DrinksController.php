<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DrinksController extends AbstractController
{
    #[Route('/drinks', name: 'drinks')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->find(7);
        $subcategories = $categoriesRepository->findBy(['parent_id' => 7]);
        return $this->render('drinks/index.html.twig', compact('categories', 'subcategories'));
    }

    #[Route('/drinks/{id}', name: 'drinks_subcategory')]
    public function choose(Categories $categories): Response
    {
        //ici on récupère les produits
        $products = $categories->getProducts();

        return $this->render('drinks/drinks.html.twig', compact('products', 'categories'));
    }

    #[Route('/{id}', name: 'drinks_details')]
    public function details(Products $products): Response
    {
        //On récupère les allergènes pour les afficher
        $allergens = $products->getAllergens();

        return $this->render('drinks/details.html.twig', compact('products', 'allergens'));
    }
}
