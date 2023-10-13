<?php

namespace App\Controller\Admin;


use App\Entity\Products;
use App\Form\ProductsFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/product', name: 'admin_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        //Route accessible uniquement par le/les admins sauf PRODUCT_ADMIN cf. security.yaml et Voter
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = new Products();
        $productForm = $this->createForm(ProductsFormType::class, $product);

        return $this->render('admin/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Products $products): Response
    {
        //Route accessible uniquement par l'admin "PRODUCT_ADMIN" cf. security.yaml et Voter
        $this->denyAccessUnlessGranted('edit', $products);
        return $this->render('admin/index.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $products): Response
    {
        //Route accessible uniquement par l'admin "SUPER_ADMIN" et "ADMIN" cf. security.yaml et Voter
        $this->denyAccessUnlessGranted('delete', $products);
        return $this->render('admin/index.html.twig');
    }
}
