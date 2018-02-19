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
                'photo_path' => $this->preparePhotos($element->getPhotos()),
                'link' => '/product/' . $element->getId()
            );
            array_push($newList, $product);
        }
        return $newList;
    }

    private function preparePhotos($photos) {
        $photoLink = "";
        if (count($photos) > 0) {
            foreach ($photos as $key => $value) {
                if (strcasecmp("", $value) == 0) {
                    $photoLink = "";
                } else {
                    $photoLink = '/' . $value;
                }
                break;
            }
        }
        return $photoLink;
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
