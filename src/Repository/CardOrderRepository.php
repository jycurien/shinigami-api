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

    // /**
    //  * @return CardOrder[] Returns an array of CardOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CardOrder
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
