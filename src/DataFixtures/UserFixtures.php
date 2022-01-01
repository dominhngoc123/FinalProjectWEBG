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
        $user = new User();
        $user->setUserEmail('ngocatp.52@gmail.com');
        $user->setRoles(["ROLE_ADMIN"]);
        //pass là 1231311 nhé
        $user->setPassword('$2y$13$tFRoEZyHESSn4bBvfJq8IeEEGIHhjxPxnLoI.cSxh.MTmO.ed60zW');
        $user->setUsername('admindemo1');
        $user->setUserFullName('Đỗ Minh Ngọc');
        $user->setUserAddress('Lào Cai');
        $user->setUserPhone('0941900193');
        $user->setUserDOB(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user->setCreateAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', time())));
        $user->setCreateBy('Đỗ Minh Ngọc');
        $manager->persist($user);
        $manager->flush();
    }
}
