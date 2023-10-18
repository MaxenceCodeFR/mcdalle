<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session): Response
    {
        $basket = $session->get('basket', []);
        dd($basket);
        return $this->render('cart/index.html.twig');
    }
    #[Route('/add-burger/{id}', name: 'add_burger')]
    public function addBurger(Products $products, SessionInterface $session)
    {
        //On recupère l'id du produit
        $id = $products->getId();

        //On recupère le panier
        $basket = $session->get('basket', []);

        //On ajoute le produit dans le panier si il n'yest pas
        //Sinon on augmente la quantité
        if (empty($basket[$id])) {
            $basket[$id] = 1;
        } else {
            $basket[$id]++;
        }

        $session->set('basket', $basket);

        return $this->redirectToRoute('drinks');
    }

    #[Route('/add-drink/{id}', name: 'add_drink')]
    public function addDrink(Products $products, SessionInterface $session)
    {
        //On recupère l'id du produit
        $id = $products->getId();

        //On recupère le panier
        $basket = $session->get('basket', []);

        //On ajoute le produit dans le panier si il n'yest pas
        //Sinon on augmente la quantité
        if (empty($basket[$id])) {
            $basket[$id] = 1;
        } else {
            $basket[$id]++;
        }

        $session->set('basket', $basket);

        return $this->redirectToRoute('desserts');
    }

    #[Route('/add-dessert/{id}', name: 'add_dessert')]
    public function addDessert(Products $products, SessionInterface $session)
    {
        //On recupère l'id du produit
        $id = $products->getId();

        //On recupère le panier
        $basket = $session->get('basket', []);

        //On ajoute le produit dans le panier si il n'yest pas
        //Sinon on augmente la quantité
        if (empty($basket[$id])) {
            $basket[$id] = 1;
        } else {
            $basket[$id]++;
        }

        $session->set('basket', $basket);

        return $this->redirectToRoute('cart_index');
    }
}
