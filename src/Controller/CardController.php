<?php


namespace App\Controller;


use App\Handler\Card\CardHandler;
use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/cards", methods={"POST"})
     * @param Request $request
     * @param CardHandler $cardHandler
     * @return JsonResponse
     */
    public function createCard(Request $request, CardHandler $cardHandler)
    {
        $parameters = json_decode($request->getContent());
        if (!isset($parameters->center)) {
            return $this->json(['errorMessage' => 'You must provide a center code'], Response::HTTP_BAD_REQUEST);
        }
        $card = $cardHandler->handle($parameters->center);
        return $this->json($card, Response::HTTP_OK, [], ['groups' => 'show_cards']);
    }
}