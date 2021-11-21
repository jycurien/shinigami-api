<?php


namespace App\Tests\Factory\Order;


use App\Entity\Card;
use App\Factory\Card\CardFactory;
use App\Factory\Order\CardOrderFactory;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CardOrderFactoryTest extends TestCase
{
    public function testCreate()
    {
        $quantity = 100;
        $mockCardFactory = $this->createMock(CardFactory::class);
        $mockCardFactory->expects($this->exactly($quantity))->method('createMaterialCard')->willReturn($this->createMock(Card::class));
        $mockEntityManager = $this->createMock(EntityManagerInterface::class);
        $cardOrderFactory = new CardOrderFactory($mockCardFactory, $mockEntityManager);
        $order = $cardOrderFactory->create(124, $quantity, 100100);
        $this->assertEquals((new \DateTime())->format('YY-mm-dd'), $order->getOrderedAt()->format('YY-mm-dd'));
        $this->assertEquals($quantity, $order->getQuantity());
        $this->assertEquals(false, $order->getReceived());
    }
}