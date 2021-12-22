<?php

namespace App\Repository;

use App\Entity\AuthorBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuthorBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthorBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthorBook[]    findAll()
 * @method AuthorBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorBook::class);
    }

    // /**
    //  * @return AuthorBook[] Returns an array of AuthorBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AuthorBook
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
