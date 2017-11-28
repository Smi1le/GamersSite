<?php
namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Acme\StoreBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $price;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $power;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $equipment;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $scale;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $kindOfChassis;

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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    
    /**
     * Set power
     *
     * @param string $power
     * @return $this
     */
    public function setPower($power)
    {
        $this->power = $power;
        return $this;
    }

    /**
     * Get power
     *
     * @return string $power
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set equipment
     *
     * @param string $equipment
     * @return $this
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;
        return $this;
    }

    /**
     * Get equipment
     *
     * @return string $equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set scale
     *
     * @param string $scale
     * @return $this
     */
    public function setScale($scale)
    {
        $this->scale = $scale;
        return $this;
    }

    /**
     * Get scale
     *
     * @return string $scale
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * Set kindOfChassis
     *
     * @param float $kindOfChassis
     * @return $this
     */
    public function setKindOfChassis($kindOfChassis)
    {
        $this->kindOfChassis = $kindOfChassis;
        return $this;
    }

    /**
     * Get kindOfChassis
     *
     * @return float $kindOfChassis
     */
    public function getKindOfChassis()
    {
        return $this->kindOfChassis;
    }

    public function toString() 
    {
        return strval($this->price) . ", ". 
            $this->name . ", ".
            $this->power . ", ".
            $this->equipment . ", ".
            $this->scale . ", ".
            strval($this->kindOfChassis) . ", ";
    }
}
