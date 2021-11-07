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
     * @Route("/create-numeric-card/{codeCenter<\d+>}")
     * @param $codeCenter
     * @param CardHandler $cardHandler
     * @return JsonResponse
     */
    public function createNumericCard($codeCenter, CardHandler $cardHandler)
    {
        $card = $cardHandler->handle($codeCenter);
        return $this->json($card);
    }
}