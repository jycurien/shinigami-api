<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @param $code
     * @return Card|null
     * @throws NonUniqueResultException
     */
    public function findBycode($code): ?Card
    {
        $centerCode = substr($code, 0, 3);
        $cardCode = substr($code, 3, 6);
        $checkSum = substr($code, 9);

        return $this->createQueryBuilder('c')
            ->andWhere('c.centerCode = :centerCode')
            ->setParameter('centerCode', $centerCode)
            ->andWhere('c.cardCode = :cardCode')
            ->setParameter('cardCode', $cardCode)
            ->andWhere('c.checkSum = :checkSum')
            ->setParameter('checkSum', $checkSum)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @return mixed
     */
    public function findLatestCreatedCards()
    {
        return $this->createQueryBuilder('c')
            ->addOrderBy("c.id",  'DESC')
            ->setMaxResults(self::LIMIT_CARDS_TO_DISPLAY)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $centerCode
     * @param string $type
     * @return int|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findMaxCardCodeByCenterAndType(int $centerCode, string $type): ?int
    {
        return $this->createQueryBuilder('c')
            ->select('MAX(c.cardCode)')
            ->where('c.centerCode = :centerCode')
            ->setParameter('centerCode', $centerCode)
            ->andWhere('c.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
