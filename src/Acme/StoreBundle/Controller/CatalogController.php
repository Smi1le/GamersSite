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
        if ($parameter == "") {
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
        return $this->render('AcmeStoreBundle:Default:catalog.html.twig', array(
            "catalog_title" => "Каталог",
            'catalog_list' => $this->getProductList($this->getByCategory($nameCategory)),
            'categories' => $this->getListCategories()
        ));
    }

    private function getProductList($products) {
        if ($products === null) {
            $products = $this->getProducts();
        }

        $newList = array();
        foreach ($products as $element) {
            $photo = count($element->getPhotos()) === 0 ? "" : $element->getPhotos()[0];
            $product = array(
                'name' => $element->getName(),
                'page_link' => '/product/' . $element->getId(),
                'photo_path' => '/' . $photo
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