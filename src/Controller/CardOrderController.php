<?php


namespace App\Controller;


use App\Repository\CardOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CardOrderController extends AbstractController
{
    /**
     * @Route("/orders", methods={"GET"})
     * @param CardOrderRepository $cardOrderRepository
     * @return JsonResponse
     */
    public function ordersWithCenterAndCardNumbers(CardOrderRepository $cardOrderRepository): JsonResponse
    {
        return $this->json($cardOrderRepository->findOrdersWithCenterAndCardNumbers());
    }
}