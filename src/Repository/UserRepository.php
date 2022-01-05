<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface; 
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function loadUserByUsername(string $username): ?User
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username = :query
                OR u.UserEmail = :query'
        )
            ->setParameter('query', $username)
            ->getOneOrNullResult();
    }

    public function searchUser(string $username)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.username LIKE :query
                OR u.UserFullName LIKE :query
                OR u.UserEmail LIKE :query'
        )
            ->setParameter('query', '%' . $username . '%')
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByFullNameASC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.UserFullName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByFullNameDESC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.UserFullName', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByUsernameASC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.username', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByUsernameDESC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.username', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByEmailASC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.UserEmail', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByEmailDESC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.UserEmail', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByRolesASC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.roles', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function sortUserByRolesDESC()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.roles', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
