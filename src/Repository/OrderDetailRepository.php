<?php

namespace App\Repository;

use App\Entity\OrderDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetail[]    findAll()
 * @method OrderDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetail::class);
    }

    /**
     * @return OrderDetail[] Returns an array of OrderDetail objects
     */
    public function findOrderDetailByOrder($orderID)
    {
        return $this->createQueryBuilder('od')
            ->andWhere('od.order = :val')
            ->setParameter('val', $orderID)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return OrderDetail[] Returns an array of OrderDetail objects
     */
    public function findOrderDetailByBook($bookID)
    {
        return $this->createQueryBuilder('od')
            ->andWhere('od.book = :val')
            ->setParameter('val', $bookID)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?OrderDetail
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
