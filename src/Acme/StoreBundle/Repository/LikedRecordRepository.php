<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 12.01.2018
 * Time: 16:41
 */

namespace Acme\StoreBundle\Repository;


use Doctrine\ODM\MongoDB\DocumentRepository;

class LikedRecordRepository extends DocumentRepository
{
    public function getProductBy($productId, $userId) {
        return iterator_to_array(
            $this->createQueryBuilder()
            ->field("product_id")->equals($productId)
            ->field("user_id")->equals($userId)
            ->getQuery()
            ->execute());
    }
}