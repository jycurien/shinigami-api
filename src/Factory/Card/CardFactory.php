<?php


namespace App\Factory\Card;


use App\Entity\Card;
use App\Entity\CardOrder;

class CardFactory
{
    /**
     * @param int $centerCode
     * @param int $cardCode
     * @return Card
     */
    public function createNumericCard(int $centerCode, int $cardCode)
    {
        $card = new Card();
        $card->setCenterCode($centerCode);
        $card->setCardCode($cardCode);
        $card->setType("numeric");
        $card->setCheckSum($card->calculateCheckSum());

        return $card;
    }

    /**
     * @param int $centerCode
     * @param int $cardCode
     * @param CardOrder $cardOrder
     * @return Card
     */
    public function createMaterialCard(int $centerCode, int $cardCode,  CardOrder $cardOrder)
    {
        $card = new Card();
        $card->setCenterCode($centerCode);
        $card->setCardCode($cardCode);
        $card->setType("material");
        $card->setCheckSum($card->calculateCheckSum());
        $card->setCardOrder($cardOrder);

        return $card;
    }
}