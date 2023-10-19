<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/orders', name: 'orders_')]
class OrdersController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(SessionInterface $session, ProductsRepository $productsRepository, EntityManagerInterface $em): Response
    {
        //On vérifie que l'utilisateur est connecté ou autorisé
        //Roles autorisés : ROLE_USER, ROLE_PRODUCT_ADMIN, ROLE_ADMIN et ROLE_SUPER_ADMIN
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Générer une référence unique pour la commande en combinant l'ID de l'utilisateur et un horodatage
        //On récupère le panier
        $basket = $session->get('basket', []);

        //On vérifie que le panier n'est pas vide
        //Même si le bouton ne s'affiche pas si il n'y a pas de produits dans le panier
        if ($basket === []) {
            return $this->redirectToRoute('landing');
        }

        //On créee la référence de la commande en combinant un id POTENTIELLEMENT unique et un horodatage
        $reference = 'CMD_' . uniqid() . '_' . time();

        //On génère ensuite la commande
        $orders =  new Orders();

        //On recupère l'utilisateur qui passe la commande et la référance de la commande
        $orders->setUsersId($this->getUser());
        $orders->setReference($reference);
        $orders->setCreatedAt(new \DateTimeImmutable());

        //Pour faire une commande, il faut recuperer les produits du panier
        //alors on boucle pour recuperer le bazar
        foreach ($basket as $item => $quantity) {
            //Pour faire une commande, il nous faut les details de la commande
            //En lien avec ce qu'il y'a dans l'entité OrdersDetails
            $orderDetails = new OrdersDetails();

            //On recupère le produit
            $product = $productsRepository->find($item);
            //On recupère son prix
            $price = $product->getPrice();

            //On ajoute les details de la commande
            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);

            $orders->addOrdersDetail($orderDetails);
        }

        //On enregistre la commande
        $em->persist($orders);
        $em->flush();

        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }
}
