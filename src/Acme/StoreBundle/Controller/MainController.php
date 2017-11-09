<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Product;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends DefaultController
{
    /**
     * @Route("/default", name="default_action")
     */
    public function indexAction(Request $request)
    {
        $string = "";
        foreach ($this->getRepository("AcmeStoreBundle:Product")->findAll() as $cursor){
            $string =$string . $cursor->toString() . "\n";
        }

        return $this->render($string);
    }
    /**
     * @Route("/", name="default_show")
     */
    public function createAction()
    {
        $arr = array(
            "title_name" => "My New Page",
            "Placeholder_search" => "Поиск",
            "boot_template" => "main_content.html.twig",
            "popular_title" => "Самое популярное",
            "sidebar_elements" => array(array("page_link" => "https://vk.com/na_fokse", "name" => "You Father")),
            "content_list" => array(0 => array("photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg", 
                "caption" => "caption", 
                "description" => "description",
                "characteristics" => array(
                    array("name" => "first", "value" => "Bl9tb"),
                    array("name" => "second", "value" => "Bl9tb")
                )),
                1 => array("photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg", 
                "caption" => "caption", 
                "description" => "description",
                "characteristics" => array(
                    array("name" => "first", "value" => "Bl9tb"),
                    array("name" => "second", "value" => "Bl9tb")
                )),
                2 => array("photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg", 
                "caption" => "caption", 
                "description" => "description",
                "characteristics" => array(
                    array("name" => "first", "value" => "Bl9tb"),
                    array("name" => "second", "value" => "Bl9tb")
                ))),
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
                )
            )
        );
        $arr = $this->addHeaderLink($arr);
        return $this->render('AcmeStoreBundle:Default:main_page.html.twig', $arr);
    }

    private function addHeaderLink($arrayResponse) {
        $arrayResponse["home_link"] = "/";
        $arrayResponse["catalog_link"] = "/catalog";
        $arrayResponse["lk_link"] = "/lk";
        return $arrayResponse;
    }

    /**
    * @Route("/catalog", name="catalog_show")
    */
    public function catalog() {
        $arr = array(
            "title_name" => "My New Page",
            "Placeholder_search" => "Поиск",
            "boot_template" => "main_content.html.twig",
            "catalog_title" => "Каталог",
            "sidebar_elements" => array(array("page_link" => "https://vk.com/na_fokse", "name" => "You Father")),
            "catalog_list" => array(
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
                    "name" => "fifth",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                ),
                array(
                    "name" => "sixth",
                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
                    "page_link" => "https://vk.com/na_fokse"
                )
            )
        );
        $arr = $this->addHeaderLink($arr);
        
        // print_r($arr);
        return $this->render('AcmeStoreBundle:Default:catalog.html.twig', $arr);
    }

    
}
