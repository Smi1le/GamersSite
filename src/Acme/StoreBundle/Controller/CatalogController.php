<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 25.11.2017
 * Time: 16:57
 */

namespace Acme\StoreBundle\Controller;


use Acme\StoreBundle\Document\Category;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\RegistrationType;
use Acme\StoreBundle\Entity\RegistrationTask;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\StoreBundle\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;


class CatalogController extends DefaultController
{


//    public function catalog() {
//        $arr = array(
//            "title_name" => "My New Page",
//            "Placeholder_search" => "Поиск",
//            "boot_template" => "main_content.html.twig",
//            "catalog_title" => "Каталог",
//            "last_added_title" => "Последние добавления",
//            "margin_top_footer" => "2000px",
//            "sidebar_elements" => array(array("page_link" => "https://vk.com/na_fokse", "name" => "You Father")),
//            "catalog_list" => array(
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
//                ),
//                array(
//                    "name" => "fifth",
//                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                    "page_link" => "https://vk.com/na_fokse"
//                ),
//                array(
//                    "name" => "sixth",
//                    "photo_path" => "http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg",
//                    "page_link" => "https://vk.com/na_fokse"
//                )
//            )
//        );
////        $arr = $this->addHeaderLink($arr);
//
//        // print_r($arr);
//        return $this->render('AcmeStoreBundle:Default:catalog.html.twig', $arr);
//    }

    /**
     * @Method({"GET"})
     * @Route("/catalog", name="catalog_show")
     * @param $request Request
     * @return \Symfony\Component\HttpFoundation\Response
     * defaults={"s"="...."}, name="search_parameter")
     */
    public function catalog(Request $request) {
        $parameter = "";
        if ($request->isMethod($request::METHOD_GET)) {
            $parameter = $request->query->get("s");
        }
        echo $parameter . '<br/>';
        if ($parameter === "") {
            return $this->render('AcmeStoreBundle:Default:catalog.html.twig', array(
                "catalog_title" => "Каталог",
                'catalog_list' => $this->getProductList(null),
                'categories' => $this->getListCategories()
            ));
        } else {
            return $this->render('AcmeStoreBundle:Default:catalog.html.twig', array(
                "catalog_title" => "Каталог",
                'catalog_list' => $this->getProductList($this->getByEntry($parameter)),
                'categories' => $this->getListCategories()
            ));
        }

    }

    /**
     * @Method({"GET"})
     * @Route("/catalog/{category}", name="catalog_show_for_category")
     * @param string $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCatalogForCategory($category) {
        $nameCategory = ucfirst(str_replace('_', ' ', $category));
        echo $nameCategory;
        echo "333333333333333".'<br/>';
        // print_r($arr);
        return $this->render('AcmeStoreBundle:Default:catalog.html.twig', array(
            "catalog_title" => "Каталог",
            'catalog_list' => $this->getProductList($this->getByCategory($nameCategory)),
            'categories' => $this->getListCategories()
        ));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/catalog?s={category}", name="catalog_show_for_name_part")
     * @param string $namePart
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCatalogForNamePart($namePart) {
//        $nameCategory = ucfirst(str_replace('_', ' ', $category));
        echo "11111111122222222".'<br/>';

        // print_r($arr);
        return $this->render('AcmeStoreBundle:Default:catalog.html.twig', array(
            "catalog_title" => "Каталог",
            'catalog_list' => $this->getProductList($this->getByEntry($namePart)),
            'categories' => $this->getListCategories()
        ));
    }

    private function getListCategories() {
        $categories = $this->getCategories();
//        print_r(count($categories));
        $newList = array();
        foreach ($categories as $category) {
//            print_r($category);
            echo "<br/>";

            $newCategory = array(
                'name' => $category->getNameRu(),
                'href' => '/catalog/' . strtolower(str_replace(' ', '_', $category->getNameEn()))
            );
            array_push($newList, $newCategory);
        }
        return $newList;
    }

    private function getProductList($products) {
//        print_r($products);
        if ($products === null) {
            $products = $this->getProducts();
            echo '111111<br/>';
        }
        $newList = array();
        foreach ($products as $element) {
            print_r($element);
            $product = array(
                'name' => $element->getName(),
                'page_link' => $element->getId(),
                'photo_path' => 'http://www.nihonbashimokei.net/data/rc-nihonbashi/image/20151029_54961c.jpg'
            );
            array_push($newList, $product);
        }
        return $newList;
    }


    private function getByCategory($category) {
        return $this
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Product')
            ->getByCategory($category);
    }

    private function getByEntry($namePart) {
        return $this
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Product')
            ->getByEntry($namePart);
    }

    private function gg() {
        $category1 = new Category();
        $category1->setNameEn("Highway");
        $category1->setNameRu("Шоссейные");
        $this->save($category1);

        $category2 = new Category();
        $category2->setNameEn("SUVs");
        $category2->setNameRu("Внедорожники");
        $this->save($category2);

        $category3 = new Category();
        $category3->setNameEn("Construction and special machinery");
        $category3->setNameRu("Строительная и спецтехника");
        $this->save($category3);

        $category = new Category();
        $category->setNameEn("Cars with copied bodies");
        $category->setNameRu("Машинки со скопированными кузовами");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Motorcycles");
        $category->setNameRu("Мотоциклы");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Models Kyosho Mini-Z");
        $category->setNameRu("Модели Kyosho Mini-Z");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Trucks and trailers");
        $category->setNameRu("Грузовики и прицепы");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Crawlers and trophies");
        $category->setNameRu("Краулеры и трофи");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Buggies");
        $category->setNameRu("Багги");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Short track corset");
        $category->setNameRu("Шорт-корс траки");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Rally");
        $category->setNameRu("Ралли");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Drift");
        $category->setNameRu("Дрифт");
        $this->save($category);

        $category = new Category();
        $category->setNameEn("Monsters");
        $category->setNameRu("Монстры");
        $this->save($category);
    }

}