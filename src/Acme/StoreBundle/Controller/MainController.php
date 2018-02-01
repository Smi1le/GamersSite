<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Document\Product;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends DefaultController
{
    /**
     * @Route("/", name="default_show")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array("popular_title" => "Самое популярное",
            "content_list" => $this->getProductList(),
            "popular_list" => array(
                array(
                    "name" => "first",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                ),
                array(
                    "name" => "second",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                ),
                array(
                    "name" => "third",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                ),
                array(
                    "name" => "fourth",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                ),
                array(
                    "name" => "fourth",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                )
            ),
            "last_added_title" => "Последние добавления",
            'categories' => $this->getListCategories()));


    }

    private function getProductList() {
        $products = $this->getProducts();
        $newList = array();
        foreach ($products as $element) {
            $product = array(
                'caption' => $element->getName(),
                'description' => $element->getShortDescription(),
                'characteristics' => $this->getCharacteristics($element->getCharacteristics()),
                'photo_path' => 'http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg',
                'link' => '/product/' . $element->getId()
            );
            array_push($newList, $product);
        }
        return $newList;
    }

    /**
     * @param array $characteristics
     * @return array $newList
     */
    private function getCharacteristics($characteristics) {
        $newList = array();
        for ($i = 0; $i < count($characteristics); $i += 2) {
            if ($i > 6) {
                break;
            }
            $characteristic = array(
                'name' => $characteristics[$i],
                'value' => $characteristics[$i + 1],
            );
            array_push($newList, $characteristic);
        }
        return $newList;
    }
}
