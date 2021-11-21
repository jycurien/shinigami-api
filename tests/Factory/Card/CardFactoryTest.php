<?php


namespace App\Tests\Factory\Card;


use App\Entity\Card;
use App\Factory\Card\CardFactory;
use PHPUnit\Framework\TestCase;

class CardFactoryTest extends TestCase
{
    public function testcreateNumericCard()
    {
        $cardFactory = new CardFactory();
        $card = $cardFactory->createNumericCard(124, 500000);
        $expectedCard = new Card();
        $expectedCard->setCenterCode(124);
        $expectedCard->setCardCode(500000);
        $expectedCard->setType("numeric");
        $expectedCard->setCheckSum(3);
        $this->assertEquals($expectedCard, $card);
    }
}