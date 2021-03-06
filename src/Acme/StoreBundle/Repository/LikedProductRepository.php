<?php

namespace Acme\StoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * LikedProductRepository
 *
 * This class was generated by the Doctrine ODM. Add your own custom
 * repository methods below.
 */
class LikedProductRepository extends DocumentRepository
{

    public function findByUserId($userId) {
        return $this->createQueryBuilder()
            ->field('user_id')->equals($userId)
            ->getQuery()
            ->execute();
    }
}
