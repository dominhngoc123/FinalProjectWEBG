<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
    /  * @return Author[] Returns an array of Author objects
    /  */
    public function findByAuthorNameOrStageName($value)
    {
        return $this->createQueryBuilder('author')
            ->andWhere('author.AuthorFullName LIKE :val')
            ->orWhere('author.AuthorStageName LIKE :val')
            ->setParameter('val', '%'. $value . '%')
            ->orderBy('author.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

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

    /**
    /  * @return Author[] Returns an array of Author based on FullName objects asc
    /  */
    public function sortByNameAsc()
    {
        return $this->createQueryBuilder('author')
            ->orderBy('author.AuthorFullName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
    /  * @return Author[] Returns an array of Author objects based on FullName desc
    /  */
    public function sortByNameDesc()
    {
        return $this->createQueryBuilder('author')
            ->orderBy('author.AuthorFullName', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
    /  * @return Author[] Returns an array of Author based on StageName objects asc
    /  */
    public function sortByStageNameAsc()
    {
        return $this->createQueryBuilder('author')
            ->orderBy('author.AuthorStageName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
    /  * @return Author[] Returns an array of Author based on StageName objects desc
    /  */
    public function sortByStageNameDesc()
    {
        return $this->createQueryBuilder('author')
            ->orderBy('author.AuthorStageName', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
