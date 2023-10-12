<?php

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DessertController extends AbstractController
{
    #[Route('/dessert', name: 'desserts')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        //Exqctement la même chose que dans le DrinksController, sauf que je récupère 
        //la catégorie a l'id 7 , les boissons
        $categories = $categoriesRepository->find(11);
        //et ici les sous-catégories qui ont pour parent l'id 7
        $subcategories = $categoriesRepository->findBy(['parent_id' => 11]);
        return $this->render('desserts/index.html.twig', compact('categories', 'subcategories'));
    }

    #[Route('/desserts/{id}', name: 'desserts_subcategory')]
    public function choose(Categories $categories): Response
    {
        //ici on récupère les produits des sous-catégories
        $products = $categories->getProducts();

        return $this->render('desserts/desserts.html.twig', compact('products', 'categories'));
    }

    #[Route('/details-desserts/{id}', name: 'desserts_details')]
    public function details(Products $products): Response
    {
        //On récupère les allergènes pour les afficher
        $allergens = $products->getAllergens();

        return $this->render('desserts/details.html.twig', compact('products', 'allergens'));
    }
}
