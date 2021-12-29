<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return Order[] Returns an array of Order objects
     */
    public function findByUserName($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.User.UserName LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('o.CreateBy', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Order[] Returns an array of Order objects
     */
    public function sortByDateASC()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('CreateAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Order[] Returns an array of Order objects
     */
    public function sortByDateDESC()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('CreateAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Order
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
