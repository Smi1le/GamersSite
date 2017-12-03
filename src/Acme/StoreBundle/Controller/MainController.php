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
    public function indexAction(Request $request)
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array("popular_title" => "Самое популярное",
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
                        array("name" => "second", "value" => "Bl9tb"),
                        array("name" => "second", "value" => "Bl9tb"),
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
            ),
            "last_added_title" => "Последние добавления"));


    }

    private function getProducts() {
//        $this->getRepository()->getRepository("AcmeStoreBundle:Product")->;
    }
//    /**
//     * @Route("/", name="default_show")
//     */
//    public function createAction()
//    {
//        $arr = array(
//            "title_name" => "My New Page",
//            "Placeholder_search" => "Поиск",
//            "boot_template" => "main_content.html.twig",
//            "margin_top_footer" => "2000px",
//            "last_added_title" => "Последние добавления",
//            "popular_title" => "Самое популярное",
//            "sidebar_elements" => array(array("page_link" => "https://vk.com/na_fokse", "name" => "You Father")),
//            "content_list" => array(0 => array("photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                "caption" => "caption",
//                "description" => "description",
//                "characteristics" => array(
//                    array("name" => "first", "value" => "Bl9tb"),
//                    array("name" => "second", "value" => "Bl9tb")
//                )),
//                1 => array("photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                "caption" => "caption",
//                "description" => "description",
//                "characteristics" => array(
//                    array("name" => "first", "value" => "Bl9tb"),
//                    array("name" => "second", "value" => "Bl9tb"),
//                    array("name" => "second", "value" => "Bl9tb"),
//                    array("name" => "second", "value" => "Bl9tb")
//                )),
//                2 => array("photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                "caption" => "caption",
//                "description" => "description",
//                "characteristics" => array(
//                    array("name" => "first", "value" => "Bl9tb"),
//                    array("name" => "second", "value" => "Bl9tb")
//                ))),
//            "popular_list" => array(
//                array(
//                    "name" => "first",
//                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                    "page_link" => "https://vk.com/na_fokse"
//                ),
//                array(
//                    "name" => "second",
//                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                    "page_link" => "https://vk.com/na_fokse"
//                ),
//                array(
//                    "name" => "third",
//                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                    "page_link" => "https://vk.com/na_fokse"
//                ),
//                array(
//                    "name" => "fourth",
//                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                    "page_link" => "https://vk.com/na_fokse"
//                )
//            )
//        );
//        $arr = $this->addHeaderLink($arr);
//        return $this->render('AcmeStoreBundle:Default:main_page.html.twig', $arr);
//    }



    private function createCatalogData() {
       return  array(
            "title_name" => "My New Page",
            "Placeholder_search" => "Поиск",
            "boot_template" => "main_content.html.twig",
            "catalog_title" => "Каталог",
            "last_added_title" => "Последние добавления",
            "margin_top_footer" => "2000px",
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
    }



    
}
