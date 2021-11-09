<?php


namespace App\Handler\Card;


use App\Entity\Card;
use App\Factory\Card\CardFactory;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;

class CardHandler
{
    const NUMERIC_CODE_CARD_MIN = 500000;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CardRepository
     */
    private $cardRepository;
    /**
     * @var CardFactory
     */
    private $cardFactory;

    public function __construct(EntityManagerInterface $entityManager, CardRepository $cardRepository, CardFactory $cardFactory)
    {

        $this->entityManager = $entityManager;
        $this->cardRepository = $cardRepository;
        $this->cardFactory = $cardFactory;
    }

    public function handle(string $centerCode): Card
    {
        // We check the max number card for the given center
        $maxCardCode = $this->cardRepository->findMaxCardCodeByCenterAndType($centerCode, 'numeric');

        if($maxCardCode) {
            $newCardCode = $maxCardCode+1;
        } else {
            $newCardCode = self::NUMERIC_CODE_CARD_MIN;
        }

        $card = $this->cardFactory->createNumericCard($centerCode, $newCardCode);

        $this->entityManager->persist($card);
        $this->entityManager->flush();

        return $card;
    }

//    /**
//     * @param $code
//     * @return Card|null
//     */
//    public function updateActivationDate($code)
//    {
//        $card = $this->manager->getRepository(Card::class)->findBycode($code);
//
//        // We check if the card exists and if the activation date is not already set
//        if($card && null == $card->getActivationDate()) {
//            $card->setActivationDate(New \DateTime());
//            $this->manager->persist($card);
//            $this->manager->flush();
//        } else {
//            // We set the card to null if it doesn't exists OR if activationDate is already set
//            $card = null;
//        }
//
//        return $card;
//    }
}