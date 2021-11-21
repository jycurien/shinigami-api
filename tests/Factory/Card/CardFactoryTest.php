<?php


namespace App\Tests\Factory\Card;


use App\Entity\Card;
use App\Entity\CardOrder;
use App\Factory\Card\CardFactory;
use PHPUnit\Framework\TestCase;

class CardFactoryTest extends TestCase
{
    public function testCreateNumericCard()
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

    public function testCreateMaterialCard()
    {
        $cardFactory = new CardFactory();
        $mockCardOrder = $this->createMock(CardOrder::class);
        $card = $cardFactory->createMaterialCard(124, 500000, $mockCardOrder);
        $expectedCard = new Card();
        $expectedCard->setCenterCode(124);
        $expectedCard->setCardCode(500000);
        $expectedCard->setType("material");
        $expectedCard->setCheckSum(3);
        $expectedCard->setCardOrder($mockCardOrder);
        $this->assertEquals($expectedCard, $card);
    }
}