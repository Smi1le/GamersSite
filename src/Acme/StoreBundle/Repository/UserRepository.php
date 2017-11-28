<?php
// src/AppBundle/Repository/UserRepository.php
namespace Acme\StoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends DocumentRepository implements UserLoaderInterface
{
    public function getByLogin($login) {
        return $this->createQueryBuilder()
            ->field('password')->equals($login)
            ->getQuery()
            ->execute();
    }


    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.login = :login OR u.email = :email')
            ->setParameter('login', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}