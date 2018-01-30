<?php

namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="Acme\StoreBundle\Repository\LikedRecordRepository")
 */
class LikedRecord
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string", name="product_id")
     */
    private $productId;

    /**
     * @MongoDB\Field(type="string", name="user_id")
     */
    private $userId;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productId
     *
     * @param $productId
     * @return $this
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    /**
     * Get productId
     *
     * @return  $productId
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set userId
     *
     * @param $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Get userId
     *
     * @return $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
