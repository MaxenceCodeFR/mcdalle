<?php

namespace App\Controller\Admin;


use App\Entity\Products;
use App\Form\ProductsFormType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/product', name: 'admin_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $products = $productsRepository->findAll();

        return $this->render('admin/products/index.html.twig', compact('products'));
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

            $file = $productForm->get("images")->getData();
            /* Créer un nom unique pour l'image et recuperer l'extension*/
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $product->setImages($fileName);
            /* Deplacer l'image dans le dossier public/images */
            $file->move($this->getParameter('uploads'), $fileName);

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_interface_index');
        }


        return $this->render('admin/products/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $em, Products $product): Response
    {
        //Route accessible uniquement par l'admin "PRODUCT_ADMIN" cf. security.yaml et Voter
        $this->denyAccessUnlessGranted('edit', $product);

        $productForm = $this->createForm(ProductsFormType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {

            $file = $productForm->get("images")->getData();
            /* Créer un nom unique pour l'image et recuperer l'extension*/
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $product->setImages($fileName);
            /* Deplacer l'image dans le dossier public/images */
            $file->move($this->getParameter('uploads'), $fileName);

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_interface_index');
        }
        return $this->render('admin/products/edit.html.twig', [
            'productForm' => $productForm->createView()
        ]);
    }
}
