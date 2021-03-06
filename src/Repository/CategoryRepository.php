<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Category[] 
     */
    public function searchCateByName ($category_name){
        // Trong này là DQL không phải sql nên em lấy các thuộc tính của Entity chứ không phải bảng trong phpmyadmin.
        return $this->createQueryBuilder('cateName') 
                    ->andWhere('cateName.CategoryName LIKE :category_name')
                    ->setParameter('category_name', '%'. $category_name. '%')
                    ->orderBy('cateName.CategoryName','ASC')
                    ->getQuery(5)
                    ->getResult();

    }

    /**
     * @return Category[] 
     */
    public function sortCateNameAsc()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.CategoryName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Category[] 
     */
    public function sortCateNameDesc()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.CategoryName', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
