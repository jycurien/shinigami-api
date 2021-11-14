<?php


namespace App\Controller;


use App\Factory\Order\CardOrderFactory;
use App\Repository\CardOrderRepository;
use App\Repository\CardRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/orders", methods={"POST"})
     * @param Request $request
     * @param CardRepository $cardRepository
     * @param CardOrderFactory $orderFactory
     * @return JsonResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function createOrder(Request $request, CardRepository $cardRepository, CardOrderFactory $orderFactory): JsonResponse
    {
        $parameters = json_decode($request->getContent());

        $startCodeCard = $cardRepository->findMaxCardCodeByCenterAndType($parameters->center, 'material') + 1;

        $order = $orderFactory->create($parameters->center, $parameters->quantity, $startCodeCard);

        return $this->json($order);
    }
}