<?php
namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Acme\StoreBundle\Repository\CategoryRepository", collection="Category1")
 */
class Category
{
    /**
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string", name="name_ru")
     */
    private $nameRu;

    /**
     * @MongoDB\Field(type="string", name="name_en")
     */
    private $nameEn;



    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function toString() {
        return $this->id. ';'.$this->nameRu;
    }

    /**
     * Set nameRu
     *
     * @param string $nameRu
     */
    public function setNameRu($nameRu)
    {
        $this->nameRu = $nameRu;
    }

    /**
     * Get nameRu
     *
     * @return string $nameRu
     */
    public function getNameRu()
    {
        return $this->nameRu;
    }

    /**
     * Set nameEn
     *
     * @param string $nameEn
     */
    public function setNameEn($nameEn)
    {
        $this->nameEn = $nameEn;
    }

    /**
     * Get nameEn
     *
     * @return string $nameEn
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }
}
