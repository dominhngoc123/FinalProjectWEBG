<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[]
     */
    public function getNewProduct () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'NEW')
            ->orderBy('b.CreateAt','DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
            ;
    }
     /**
     * @return Book[]
     */
    public function getHotProduct () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'HOT')
            ->orderBy('b.CreateAt','DESC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
            ;
    }
          /**
     * @return Book[]
     */
    public function sortHotProductByPriceDESC () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'HOT')
            ->orderBy('b.BookPrice','DESC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
            ;
    }
          /**
     * @return Book[]
     */
    public function sortHotProductByPriceASC () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'HOT')
            ->orderBy('b.BookPrice','ASC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
            ;
    }
     /**
     * @return Book[]
     */
    public function sortHotProductByNameDESC () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'HOT')
            ->orderBy('b.BookTitle','DESC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
            ;
    }
           /**
     * @return Book[]
     */
    public function sortHotProductByNameASC () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'HOT')
            ->orderBy('b.BookTitle','ASC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
            ;
    }
     /**
     * @return Book[]
     */
    public function getSellerProduct () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'SELLER')
            ->orderBy('b.CreateAt','DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }
         /**
     * @return Book[]
     */
    public function getSellerProductHome () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'SELLER')
            ->orderBy('b.CreateAt','DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }
      /**
     * @return Book[]
     */
    public function getPopularProduct () {
        return $this->createQueryBuilder('b')
            ->andWhere('b.type_product = :val')
            ->setParameter('val', 'POPULAR')
            ->orderBy('b.CreateAt','DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }
    /**
     * @return Book[]
     */
    public function searchByTitle ($title) {
        return $this->createQueryBuilder('book')
                    ->andWhere('book.BookTitle LIKE :title')
                    ->setParameter('title', '%' . $title . '%')
                    ->orderBy('book.BookTitle','asc')
                    ->setMaxResults(50)
                    ->getQuery()
                    ->getResult()
                    ;
    }
    public function getBookById($bookId): ?Book
    {
        return $this->createQueryBuilder('book')
            ->where('book.id = :val')
            ->setParameter('val', $bookId)
            ->getQuery()
            ->getOneOrNullResult();
    }

        /**
     * @return Book[]
     */
    public function sortBookAsc() {
        return $this->createQueryBuilder('book')
                    ->orderBy('book.BookTitle', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

     /**
     * @return Book[]
     */
    public function sortBookDesc() {
        return $this->createQueryBuilder('book')
                    ->orderBy('book.BookTitle', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }
    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
