<?php

namespace App\Controller\Admin;


use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //Route accessible uniquement par le/les admins sauf PRODUCT_ADMIN cf. security.yaml et Voter
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $product = new Products();
        $productForm = $this->createForm(ProductsFormType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté');
            return $this->redirectToRoute('admin_index');
        }


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
