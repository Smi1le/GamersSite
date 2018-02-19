<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 15.02.2018
 * Time: 18:24
 */

namespace Acme\StoreBundle\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;

class CreatedProductRepository extends DocumentRepository
{
    /**
     * @param $productId
     * @return mixed
     */
    public function getByProductId($productId) {
        return $this->createQueryBuilder()
            ->field("productId")->equals($productId)
            ->getQuery()
            ->execute();
    }
}