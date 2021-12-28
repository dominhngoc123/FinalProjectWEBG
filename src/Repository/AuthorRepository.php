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
      * @return Author[] Returns an array of Author objects
      */
    
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
    


    public function findOneBySomeField($value): ?Author
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    public function findByAuthorNameOrStageName($searchContent)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.AuthorFullName = :val')
            ->orWhere('a.AuthorStageName = :val')
            ->setParameter('val', $searchContent)
            ->getQuery()
            ->getResult();
    }

    public function sortByStageNameAsc()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.AuthorStageName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function sortByStageNameDesc()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.AuthorStageName', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function sortByNameAsc()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.AuthorFullName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function sortByNameDesc()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.AuthorFullName', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
