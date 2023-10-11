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

//Dans ce controller on retrouve les premières pages qui permettent d'afficher la 
//la première catégorie du parcours de l'utilisateur, puis la sous-catégorie et enfin le produit

class LandingController extends AbstractController
{
    #[Route('/choose', name: 'landing')]
    public function index(ProductsRepository $productsRepository, AllergensRepository $allergensRepository, CategoriesRepository $categoriesRepository): Response
    {
        //C'est ici qu'on récupère la première catégorie
        $categories = $categoriesRepository->find(1);
        //et c'est ici qu'ont récupère les sous-catégories
        $subcategories = $categoriesRepository->findBy(['parent_id' => 1]);
        // On essaye d'éviter les requêtes overkill comme findAll() car on a pas besoin de tout récupérer

        return $this->render('landing/index.html.twig', compact('categories', 'subcategories'));
    }

    //La subcatégorie permet d'afficher les produits
    #[Route('/choose/{id}', name: 'subcategory')]
    public function choose(Categories $categories): Response
    {
        //ici on récupère les produits
        $products = $categories->getProducts();

        return $this->render('landing/choose.html.twig', compact('products', 'categories'));
    }

    //Ici on affiche le détail des produits quand on clique sur la subcatégorie
    #[Route('/{id}', name: 'details')]
    public function details(Products $products): Response
    {
        //On récupère les allergènes pour les afficher
        $allergens = $products->getAllergens();

        return $this->render('landing/details.html.twig', compact('products', 'allergens'));
    }
}

// C'était la première partie du parcours de l'utilisateur, maintenant on va se retrouver dans le DrinksController 
//pour la suite du parcours
