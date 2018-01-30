<?php
namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


use Symfony\Component\Validator\Constraints as Assert;

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
     * @MongoDB\Field(type="string")
     */
    protected $category;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $characteristics;

    /**
     * @MongoDB\Field(type="date")
     */
    private $date;

    /**
     * @MongoDB\Field(type="string")
     */
    private $description;

    /**
     * @MongoDB\Field(type="collection")
     *
     */
    private $addressList;

    /**
     * @MongoDB\Field(type="collection")
     */
    private $photos;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\Length(
     *     max = 100,
     *     maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     *     )
     */
    private $shortDescription;

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
     * Set characteristics
     *
     * @param array $characteristics
     * @return $this
     */
    public function setCharacteristics(array $characteristics)
    {
        $this->characteristics = $characteristics;
        return $this;
    }

    /**
     * Get characteristics
     *
     * @return array $characteristics
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set addressList
     *
     * @param array $addressList
     * @return $this
     */
    public function setAddressList(array $addressList)
    {
        $this->addressList = $addressList;
        return $this;
    }

    /**
     * Get addressList
     *
     * @return array $addressList
     */
    public function getAddressList()
    {
        return $this->addressList;
    }

    /**
     * Set listPhotos
     *
     * @param array $listPhotos
     */
    public function setPhotos($listPhotos)
    {
        $this->photos = $listPhotos;
    }

    /**
     * Get listPhotos
     * @return array $photos
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string $shortDescription
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set date
     *
     * @param \MongoDate $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \MongoDate $date
     */
    public function getDate()
    {
        return $this->date;
    }
}
