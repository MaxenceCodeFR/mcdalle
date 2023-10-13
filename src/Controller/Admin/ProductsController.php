<?php

namespace App\Controller\Admin;


use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class ProductsController extends AbstractController
{
    #[Route('/product', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/index.html.twig');
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Products $products): Response
    {
        $this->denyAccessUnlessGranted('edit', $products);
        return $this->render('admin/index.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $products): Response
    {
        $this->denyAccessUnlessGranted('delete', $products);
        return $this->render('admin/index.html.twig');
    }
}
