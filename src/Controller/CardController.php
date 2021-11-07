<?php


namespace App\Controller;


use App\Repository\CardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        return $this->json($cardRepository->findLatestCreatedCards());
    }
}