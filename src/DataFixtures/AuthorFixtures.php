<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $author = new Author();
        $author->setAuthorFullName('Ernest Miller Hemingway');
        $author->setAuthorStageName('Ernest Hemingway');
        $author->setAuthorDescription('Ernest Miller Hemingway was an American novelist.');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $author->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $author->setCreateBy('Bùi Thị Trang');
        $manager->persist($author);

        $author1 = new Author();
        $author1->setAuthorFullName('Samuel Langhorne Clemens');
        $author1->setAuthorStageName('Mark Twain');
        $author1->setAuthorDescription('An American writers.');
        $author1->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $author1->setCreateBy('Bùi Thị Trang');
        $manager->persist($author1);

        $author2 = new Author();
        $author2->setAuthorFullName('Joanne Rowling');
        $author2->setAuthorStageName('J.K.Rowling');
        $author2->setAuthorDescription('A British author.');
        $author2->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $author2->setCreateBy('Bùi Thị Trang');
        $manager->persist($author2);

        $author3 = new Author();
        $author3->setAuthorFullName('Count Lev Nikolayevich Tolstoy');
        $author3->setAuthorStageName('Leo Tolstoy');
        $author3->setAuthorDescription('A Russian author.');
        $author3->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $author3->setCreateBy('Bùi Thị Trang');
        $manager->persist($author3);

        $author4 = new Author();
        $author4->setAuthorFullName('William Shakespeare');
        $author4->setAuthorStageName('William Shakespeare');
        $author4->setAuthorDescription('An English author.');
        $author4->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $author4->setCreateBy('Bùi Thị Trang');
        $manager->persist($author4);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
