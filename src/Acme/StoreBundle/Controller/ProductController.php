<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\LikedRecord;
use Acme\StoreBundle\Document\Product;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\CreateProductType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends DefaultController
{
    const USER_NOT_LOGGED_IN = 'USER_NOT_LOGGED_IN';
    const IS_LIKED = 'true';
    const SUCCESS = 'OK';
    const ARRAY_TYPE = 'array';
    const LIKED_PRODUCT_REPOSITORY = 'AcmeStoreBundle:LikedRecord';
    const PRODUCT_TEMPLATE = 'AcmeStoreBundle:Default:product.html.twig';
    const UTC = 'UTC';
    const FORM_FACTORY = 'form.factory';
    const DATE_FORMAT = 'Y-m-d H:i:s';
    const CREATE_PRODUCT_TEMPLATE = 'AcmeStoreBundle:Default:create_product.html.twig';
    const PHOTOS_DIRECTORY = 'photos_directory';

    /**
     * @Method("POST")
     * @param Request $request
     * @Route("/liked/{isLiked}/{id}", name="liked")
     * @return Response
     */
    public function liked(Request $request, $isLiked, $id) {
        $user = $this->getUserByRequest($request);
        if (!$user) {
            return new Response(self::USER_NOT_LOGGED_IN);
        }
        if (strcasecmp(self::IS_LIKED, $isLiked) == 0) {
            $this->markedLiked($id, $user);
        } else {
            $this->uncheck($id, $user);
        }
        return new Response(self::SUCCESS);
    }

    /**
     * @param $id
     * @param $user User
     */
    private function markedLiked($productId, $user) {
        $record = new LikedRecord();
        $record->setUserId($user->getId());
        $record->setProductId($productId);
        $this->save($record);
    }

    private function uncheck($id, $user) {
        $records = $this->getRecord($id, $user->getId());
        if ($records) {
            if ($records > 0 && gettype($records) === self::ARRAY_TYPE) {
                foreach ($records as $value) {
                    $this->remove($value);
                }
            }
        }
    }

    private function getRecord($productId, $userId) {
        return $this->get(self::DOCTRINE)
            ->getManager()
            ->getRepository(self::LIKED_PRODUCT_REPOSITORY)
            ->getProductBy($productId, $userId);
    }


    /**
     * @Method({"GET"})
     * @param Request $request
     * @Route("/product/{productId}", name="product_show")
     * @return Response
     */
    public function productPage(Request $request, $productId)
    {
//        echo $this->getRequest();
        $product = $this->getById($productId);
        $photos = $product->getPhotos();
        $photoLink = "";
        if (count($photos) > 0) {
            foreach ($photos as $key => $value) {
                $photoLink = '/' . $value;
                break;
            }
        }
        $arr = array(
            "title_name" => "My New Page",
            "Placeholder_search" => "Поиск",
            "catalog_title" => "Каталог",
            "product_image_link" => $photoLink,
            "product_name" => $product->getName(),
            "product_description" => $product->getDescription(),
            "categories" => $this->getListCategories(),
            "product_characteristics" => $this->processCharacteristicsListBeforeRendering($product),
            "product_links" => $product->getAddressList(),
            "product_id" => $productId,
            'is_liked' => $this->isMarked($request, $productId)
        );

        $arr = $this->addHeaderLink($arr);
        return $this->render(self::PRODUCT_TEMPLATE, $arr);
    }

    private function isMarked($request, $productId) {
        $user = $this->getUserByRequest($request);
        if (!$user) {
            return false;
        }
        $record = $this->getRecord($productId, $user->getId());
        if ($record) {
            return true;
        } else {
            return false;
        }
    }

    private function getById($id) {
        $arr = $this
            ->getManager()
            ->getRepository(self::PRODUCT_REPOSITORY)
            ->findById($id);
        foreach ($arr as $key => $value) {
            return $value;
        }
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/create-product", name="create_product")
     * @param $request Request
     * @return Response
     */
    public function createProductAction(Request $request) {
        $product = new Product();
        date_default_timezone_set(self::UTC);
        $categories = $this->getAllCategories();
        $form = $this->get(self::FORM_FACTORY)->create(CreateProductType::class, $product,
                                                    array('categories' => $this->processCategories($categories)));
        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                print_r(get_object_vars($product));
                $this->processCharacteristicsList($product);
                $this->uploadFiles($product);
                $product->setDate(new \MongoDate(strtotime(date(self::DATE_FORMAT))));
                $this->save($product);
                return new Response("#". $product->getId());
            }
        }
        $arr = array('form' => $form->createView());
        return $this->render(self::CREATE_PRODUCT_TEMPLATE, $arr);
    }

    /**
     * @param $product Product
     */
    private function uploadFiles($product) {
        $photos = $product->getPhotos();
        $outPhotos = array();
        for ($i = 0; $i < count($photos); $i++){
            $file = $photos[$i];
            echo $file;
            $fileName = md5(uniqid()). '.'. $file->guessExtension();
            $file->move(
                $this->getParameter(self::PHOTOS_DIRECTORY),
                $fileName
            );
            echo $fileName;
            array_push($outPhotos, $this->getParameter(self::PHOTOS_DIRECTORY). "\\". $fileName);
        }
        print_r($outPhotos);
        $product->setPhotos($outPhotos);
    }

    /**
     * @param $product Product
     */
    private function processCharacteristicsList($product) {
        $characteristics = $product->getCharacteristics();
        $newCharacteristics = array();
        for ($i = 0; $i < count($characteristics); $i += 2) {
            $name = $characteristics[$i];
            $value = $characteristics[$i + 1];
            array_push($newCharacteristics, $name, $value);
        }
        $product->setCharacteristics($newCharacteristics);
    }

    /**
     * @return mixed
     */
    private function getAllCategories() {
        return $this
            ->getManager()
            ->getRepository(self::CATEGORY_REPOSITORY)
            ->findAll();
    }

    /**
     * @param $product Product
     * @return array
     */
    private function processCharacteristicsListBeforeRendering($product) {
        $characteristics = $product->getCharacteristics();
        $newCharacteristics = array();
        for ($i = 0; $i < count($characteristics); $i += 2) {
            $name = $characteristics[$i];
            $value = $characteristics[$i + 1];
            array_push($newCharacteristics, array('name' => $name, 'value' => $value));
        }
        return $newCharacteristics;
    }

    /**
     * @param $categories array
     * @return string $list
     */
    private function processCategories($categories) {
        $list = '';
        for ($i = 0; $i < count($categories); $i++) {
            $list = $list . '$'. $categories[$i]->getNameEn();
        }
        return $list;
    }
}
