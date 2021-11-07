<?php


namespace App\Controller;


use App\Handler\Card\CardHandler;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/cards", methods={"GET"})
     * @param CardRepository $cardRepository
     * @return JsonResponse
     */
    public function findLatestCreatedCards(CardRepository $cardRepository): JsonResponse
    {
        $cards = $cardRepository->findLatestCreatedCards();
        return $this->json($cards, Response::HTTP_OK, [], ['groups' => 'show_cards']);
    }

    /**
     * @Route("/create-numeric-card/{centerCode<\d+>}")
     * @param string $centerCode
     * @param CardHandler $cardHandler
     * @return JsonResponse
     */
    public function createNumericCard(string $centerCode, CardHandler $cardHandler)
    {
        $card = $cardHandler->handle($centerCode);
        return $this->json($card, Response::HTTP_OK, [], ['groups' => 'show_cards']);
    }
}