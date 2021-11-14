<?php


namespace App\Factory\Order;


use App\Entity\CardOrder;
use App\Factory\Card\CardFactory;
use Doctrine\ORM\EntityManagerInterface;

class CardOrderFactory
{
    /**
     * @var CardFactory
     */
    private $cardFactory;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(CardFactory $cardFactory, EntityManagerInterface $entityManager)
    {
        $this->cardFactory = $cardFactory;
        $this->entityManager = $entityManager;
    }

    public function create(int $codeCenter, int $quantity, int $startCodeCard): CardOrder
    {
        $order = new CardOrder();
        $order->setQuantity($quantity);
        for ($i = 0; $i < $quantity; $i++) {
            $card = $this->cardFactory->createMaterialCard($codeCenter, $startCodeCard + $i, $order);
            $this->entityManager->persist($card);
        }
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}