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
    const CATALOG_TEMPLATE = 'AcmeStoreBundle:Default:catalog.html.twig';
    const CATALOG_TITLE = 'Каталог';

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

        $catalogList = null;
        if ($parameter == "") {
            $catalogList = $this->getProductList(null);
        } else {
            $catalogList = $this->getProductList($this->getByEntry($parameter));
        }

        return $this->render(self::CATALOG_TEMPLATE, array(
            "catalog_title" => self::CATALOG_TITLE,
            'catalog_list' => $catalogList,
            'categories' => $this->getListCategories()
        ));

    }

    /**
     * @Method({"GET"})
     * @Route("/catalog/{category}", name="catalog_show_for_category")
     * @param string $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCatalogForCategory($category) {
        $nameCategory = ucfirst(str_replace('_', ' ', $category));
        return $this->render(self::CATALOG_TEMPLATE, array(
            "catalog_title" => self::CATALOG_TITLE,
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
            ->get(self::DOCTRINE)
            ->getManager()
            ->getRepository(self::PRODUCT_REPOSITORY)
            ->getByCategory($category);
    }

    private function getByEntry($namePart) {
        return $this
            ->get(self::DOCTRINE)
            ->getManager()
            ->getRepository(self::PRODUCT_REPOSITORY)
            ->getByEntry($namePart);
    }
}