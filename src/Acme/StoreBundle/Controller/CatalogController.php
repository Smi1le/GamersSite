<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 25.11.2017
 * Time: 16:57
 */

namespace Acme\StoreBundle\Controller;


use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\RegistrationType;
use Acme\StoreBundle\Entity\RegistrationTask;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\StoreBundle\Controller;
use Symfony\Component\HttpFoundation\Request;


class CatalogController extends DefaultController
{

    /**
     * @Method({"GET"})
     * @Route("/catalog", name="catalog_show")
     */
    public function catalog() {
        $arr = array(
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
        $arr = $this->addHeaderLink($arr);

        // print_r($arr);
        return $this->render('AcmeStoreBundle:Default:catalog.html.twig', $arr);
    }

}