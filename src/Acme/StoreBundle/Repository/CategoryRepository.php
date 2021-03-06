<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 03.12.2017
 * Time: 19:28
 */

namespace Acme\StoreBundle\Repository;


use Doctrine\ODM\MongoDB\DocumentRepository;

class CategoryRepository extends DocumentRepository
{
    public function findSortedByName() {
        return $this->createQueryBuilder()
            ->sort("_id", "ASC")
            ->getQuery()
            ->execute();
    }
}