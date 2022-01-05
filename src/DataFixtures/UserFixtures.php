<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $user = new User();
        $user->setUserEmail('ngocatp.52@gmail.com');
        $user->setRoles(["ROLE_ADMIN"]);
        //pass là 1231311 nhé
        $user->setPassword('$2y$13$tFRoEZyHESSn4bBvfJq8IeEEGIHhjxPxnLoI.cSxh.MTmO.ed60zW');
        $user->setUsername('ngocadmin123');
        $user->setUserFullName('Đỗ Minh Ngọc');
        $user->setUserAddress('Lào Cai');
        $user->setUserPhone('0941900193');
        $user->setUserDOB(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user->setCreateAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($user);

        $user1 = new User();
        $user1->setUserEmail('snowfall2801@gmail.com');
        $user1->setRoles(["ROLE_ADMIN"]);
        //pass là 1231311 nhé
        $user1->setPassword('$2y$13$tFRoEZyHESSn4bBvfJq8IeEEGIHhjxPxnLoI.cSxh.MTmO.ed60zW');
        $user1->setUsername('trangadmin123');
        $user1->setUserFullName('Bùi Thị Trang');
        $user1->setUserAddress('Hà Nội');
        $user1->setUserPhone('0941900193');
        $user1->setUserDOB(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user1->setCreateAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user1->setCreateBy('Bùi Thị Trang');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUserEmail('taink@gmail.com');
        $user2->setRoles(["ROLE_ADMIN"]);
        //pass là 1231311 nhé
        $user2->setPassword('$2y$13$tFRoEZyHESSn4bBvfJq8IeEEGIHhjxPxnLoI.cSxh.MTmO.ed60zW');
        $user2->setUsername('taiadmin123');
        $user2->setUserFullName('Nguyễn Khắc Tài');
        $user2->setUserAddress('Hà Tĩnh');
        $user2->setUserPhone('0941900193');
        $user2->setUserDOB(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user2->setCreateAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user2->setCreateBy('Nguyễn Khắc Tài');
        $manager->persist($user2);
        $manager->flush();
    }
}
