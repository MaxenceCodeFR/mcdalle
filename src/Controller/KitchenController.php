<?php

namespace App\Controller;

use App\Entity\OrdersDetails;
use App\Repository\OrdersRepository;
use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrdersDetailsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/kitchen', name: 'kitchen_')]
class KitchenController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        OrdersDetailsRepository $ordersDetailsRepository,
        OrdersDetails $ordersDetails,
        OrdersRepository $ordersRepository
    ): Response {
        $orders = $ordersRepository->findBy([], ['created_at' => 'ASC']);


        return $this->render('kitchen/index.html.twig', compact('orders'));
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteOrder(EntityManagerInterface $entityManager, $id): Response
    {
        $order = $entityManager->getRepository(Orders::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('La commande n\'existe pas.');
        }

        $entityManager->remove($order);
        $entityManager->flush();

        // Redirige vers la page d'origine ou une autre page de ton choix.
        return $this->redirectToRoute('kitchen_index');
    }
}
