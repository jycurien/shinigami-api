<?php


namespace App\Controller;


use App\Handler\Card\CardHandler;
use App\Repository\CardRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * Cherche une carte a partir du motif (code)
     * @Route("/cards/code-{code<\d+>}", methods={"GET"})
     * @param string $code
     * @param CardRepository $cardRepository
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function findCardByCode(string $code, CardRepository $cardRepository): JsonResponse
    {
        $card = $cardRepository->findBycode($code);
        return $this->json($card, Response::HTTP_OK, [], ['groups' => 'show_cards']);
    }

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
    public function createCard(Request $request, CardHandler $cardHandler): JsonResponse
    {
        $parameters = json_decode($request->getContent());
        if (!isset($parameters->center)) {
            return $this->json(['errorMessage' => 'You must provide a center code'], Response::HTTP_BAD_REQUEST);
        }
        $card = $cardHandler->handle($parameters->center);
        return $this->json($card, Response::HTTP_OK, [], ['groups' => 'show_cards']);
    }

    /**
     * @Route("/cards/{code<\d+>}", methods={"PUT"})
     * @param $code
     * @param CardHandler $cardHandler
     * @return JsonResponse
     */
    public function updateActivationDate($code, CardHandler $cardHandler): JsonResponse
    {
        $card = $cardHandler->updateActivationDate($code);
        return $this->json($card, Response::HTTP_OK, [], ['groups' => 'show_cards']);
    }
}