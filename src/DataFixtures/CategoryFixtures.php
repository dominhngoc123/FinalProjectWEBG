<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setCategoryName('Sentimental novel - romantic fiction');
        $category->setCategoryDescription('Love story');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $category->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $category->setCreateBy('Bùi Thị Trang');
        $manager->persist($category);

        $category1 = new Category();
        $category1->setCategoryName('Funny story');
        $category1->setCategoryDescription('Funny story');
        $category1->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $category1->setCreateBy('Bùi Thị Trang');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setCategoryName('Horror');
        $category2->setCategoryDescription('Frighten, scare, or disgust');
        $category2->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $category2->setCreateBy('Bùi Thị Trang');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setCategoryName('Fiction');
        $category3->setCategoryDescription('Not real problems.');
        $category3->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $category3->setCreateBy('Bùi Thị Trang');
        $manager->persist($category3);
        $manager->flush();
    }
}
