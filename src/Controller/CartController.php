<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProductsRepository $productsRepository): Response
    {
        //On recupère le panier via la session
        $basket = $session->get('basket', []);

        //On crée un tableau vide qui contiendra les données à afficher
        $data = [];
        //On initialise le total à 0
        $total = 0;

        //On boucle sur nos produits enregistrés dans le panier
        foreach ($basket as $id => $quantity) {
            //On recupère le produit en fonction de l'id
            $product = $productsRepository->find($id);
            //On ajoute le produits et la quantité dans le tableau data
            $data[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
            //On multiplie alros le prix du produit par la quantité

            $total += $product->getPrice() * $quantity;
        }

        return $this->render('cart/index.html.twig', compact('data', 'total'));
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
    ///////////////////////////////////////////////////////////////////////////
    //Jusque ici on ajouter des produits en suivant une route prédéfinie//////
    //A partir de là, on est dans le panier mais on veut le gerer/////////////
    //On crée les méthodes pour augmenter, diminuer ou supprimer un produit//
    /////////////////////////////////////////////////////////////////////////

    //Cette est similaire a l'ajout du produit mais la boucle `if` va devoir 
    //décrémenter la quantité si elle est supérieur à 1
    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Products $products, SessionInterface $session)
    {
        $id = $products->getId();
        $basket = $session->get('basket', []);

        //Si le panier n'est pas vide et si la quantité est supérieur à 1
        //On décrémente la quantité
        //Sinon on supprime le produit du panier grace à la fonction unset()
        if (!empty($basket[$id])) {
            if ($basket[$id] > 1) {
                $basket[$id]--;
            } else {
                unset($basket[$id]);
            }
        }

        $session->set('basket', $basket);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $products, SessionInterface $session)
    {
        $id = $products->getId();
        $basket = $session->get('basket', []);

        //On supprime le produit du panier grace à la fonction unset()
        //Si le panier contient un produit on peut supprimer le produit
        if (!empty($basket[$id])) {
            unset($basket[$id]);
        }


        $session->set('basket', $basket);

        return $this->redirectToRoute('cart_index');
    }

    //On crée une méthode pour vider le panier
    #[Route('/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        //On supprime la session et donc le panier grace à la fonction remove()
        $session->remove('basket');

        return $this->redirectToRoute('cart_index');
    }
}
