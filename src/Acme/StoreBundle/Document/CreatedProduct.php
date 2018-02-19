<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 15.02.2018
 * Time: 18:18
 */

namespace Acme\StoreBundle\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Acme\StoreBundle\Repository\CreatedProductRepository")
 */
class CreatedProduct
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $userId;

    /**
     * @MongoDB\Field(type="string")
     */
    private $productId;

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
     * Set userId
     *
     * @param string $userId
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
     * @return string $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set productId
     *
     * @param string $productId
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
     * @return string $productId
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
