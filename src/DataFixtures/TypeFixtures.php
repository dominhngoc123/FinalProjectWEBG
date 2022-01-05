<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type = new Type();
        $type->setTypeName('Long episode story');
        $type->setTypeDescription('Story more than 100 chapters');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $type->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $type->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($type);
        $type1 = new Type();
        $type1->setTypeName('Short episode story');
        $type1->setTypeDescription('Story less than 100 chapters');
        $type1->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $type1->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($type1);
        $type2 = new Type();
        $type2->setTypeName('Magazines');
        $type2->setTypeDescription('A periodical publication which is printed in gloss-coated and matte paper');
        $type2->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $type2->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($type2);
        $type3 = new Type();
        $type3->setTypeName('Comic');
        $type3->setTypeDescription('A medium used to express ideas with images, often combined with text or other visual information');
        $type3->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $type3->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($type3);
        $type4 = new Type();
        $type4->setTypeName('References');
        $type4->setTypeDescription('A type of document that outlines procedures as they relate to a particular activity');
        $type4->setCreateAt(\DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time())));
        $type4->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($type4);
        $manager->flush();
    }
}
