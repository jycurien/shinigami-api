<?php


namespace App\Controller;


use App\Entity\CardOrder;
use App\Factory\Order\CardOrderFactory;
use App\Repository\CardOrderRepository;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->json($order, Response::HTTP_OK, [], ['groups' => 'show_order']);
    }

    /**
     * @Route("/orders/{id<\d+>}", methods={"PUT"})
     * @param CardOrder $order
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function receiveOrder(CardOrder $order, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $parameters = json_decode($request->getContent());

        if (null === $parameters->received) {
            return $this->json(['errorMessage' => 'You must provide a received state'], Response::HTTP_BAD_REQUEST);
        }

        $order->setReceived(true);
        $entityManager->flush();

        return $this->json($order, Response::HTTP_OK, [], ['groups' => 'show_order']);
    }
}