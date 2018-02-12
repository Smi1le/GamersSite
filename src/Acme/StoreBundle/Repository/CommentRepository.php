<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 11.02.2018
 * Time: 15:07
 */

namespace Acme\StoreBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class CommentRepository extends DocumentRepository
{
    /**
     * @param $productId
     * @return mixed
     */
    public function getByProductId($productId) {
        return $this->createQueryBuilder()
            ->field("productId")->equals($productId)
            ->sort("_id", "ASC")
            ->getQuery()
            ->execute();
    }

}