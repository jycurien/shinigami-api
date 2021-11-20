<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Entity\CardOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($j = 0; $j < 3; $j++) {
            $order = new CardOrder();
            $order->setQuantity(100);
            for ($i = 0; $i < 100; $i++) {
                $card = new Card();
                $card->setType('material');
                $card->setCenterCode(124+$j);
                $card->setCardCode(100000 + $i);
                $card->setCheckSum($card->calculateCheckSum());
                $card->setCardOrder($order);
                $manager->persist($card);
            }
            $manager->persist($order);
        }

        $actvatedCard = new Card();
        $actvatedCard->setType('material');
        $actvatedCard->setCenterCode(126);
        $actvatedCard->setCardCode(100100);
        $actvatedCard->setCheckSum($actvatedCard->calculateCheckSum());
        $actvatedCard->setActivatedAt(new \DateTimeImmutable());
        $manager->persist($actvatedCard);

        $manager->flush();
    }
}
