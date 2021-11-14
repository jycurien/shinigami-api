<?php

namespace App\Repository;

use App\Entity\CardOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardOrder[]    findAll()
 * @method CardOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardOrder::class);
    }

    public function findOrdersWithCenterAndCardNumbers()
    {
        return $this->createQueryBuilder('co')
            ->leftJoin('co.cards', 'c')
            ->select(
                'co.id,
                        co.orderedAt,
                        co.quantity,
                        co.received,
                        c.centerCode,
                        MIN(c.cardCode) as minCardCode,
                        MAX(c.cardCode) as maxCardCode')
            ->groupBy('co.id')
            ->distinct('co.id')
            ->addOrderBy("co.orderedAt",  'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
