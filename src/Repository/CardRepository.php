<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    const LIMIT_CARDS_TO_DISPLAY = 20;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    public function findLatestCreatedCards()
    {
        return $this->createQueryBuilder('c')
            ->addOrderBy("c.id",  'DESC')
            ->setMaxResults(self::LIMIT_CARDS_TO_DISPLAY)
            ->getQuery()
            ->getResult()
            ;
    }
}
