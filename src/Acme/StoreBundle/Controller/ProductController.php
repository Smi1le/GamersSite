<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Comment;
use Acme\StoreBundle\Document\CreatedProduct;
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
    const ARRAY_TYPE = 'array';
    const PRODUCT_ROUTE = '/product';
    const PRODUCT_TEMPLATE = 'AcmeStoreBundle:Default:product.html.twig';
    const UTC = 'UTC';
    const FORM_FACTORY = 'form.factory';
    const DATE_FORMAT = 'Y-m-d H:i:s';
    const CREATE_PRODUCT_TEMPLATE = 'AcmeStoreBundle:Default:create_product.html.twig';

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
     * @Method("POST")
     * @param Request $request
     * @Route("/product/addComment", name="addComment")
     * @return Response
     */
    public function addComment(Request $request) {

        $user = $this->getUserByRequest($request);
        if (!$user) {
            return new Response(self::USER_NOT_LOGGED_IN);
        }
        $comment = $this->createComment($request, $user);
        $this->save($comment);
        return new Response(self::SUCCESS);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Comment
     */
    private function createComment($request, $user) {
        $message = $request->get('comment');
        $productId = $request->get('productId');
        $comment = new Comment();
        $comment->setProductId($productId);
        $comment->setUserId($user->getId());
        $comment->setMessage($message);
        $comment->setDate(new \MongoDate(strtotime(date(self::DATE_FORMAT))));
        return $comment;
    }


    /**
     * @param $productId
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

    /**
     * @Method({"POST"})
     * @param $productId
     * @Route("/product/delete/{productId}", name="delete_product")
     * @return mixed
     */
    public function deleteProductInfo($productId) {
        $manager = $this->getManager();

        $product = $this->getManager()->getRepository(self::PRODUCT_REPOSITORY)->findOneBy(["_id" => $productId]);
        $this->removeElement($manager, $product);

        $likedRecords = $this->getManager()->getRepository(self::LIKED_PRODUCT_REPOSITORY)->findOneBy(["productId" => $productId]);
        $this->removeElement($manager, $likedRecords);

        $comments = $this->getManager()->getRepository(self::COMMENT_REPOSITORY)->findOneBy(["productId" => $productId]);
        $this->removeElement($manager, $comments);

        $createdProductRecords = $this->getManager()->getRepository(self::CREACTED_PRODUCT_REPOSITORY)->findOneBy(["productId" => $productId]);
        $this->removeElement($manager, $createdProductRecords);

        $manager->flush();
        return new Response(self::SUCCESS);
    }

    private function removeElement($manager, $element) {
        if ($element != null) {
            $manager->remove($element);
        }
    }

    /**
     * @Method({"POST"})
     * @param Request $request
     * @Route("/product/acceptChanges/{productId}", name="accept_changes")
     * @return mixed
     */
    public function accept(Request $request, $productId) {
        $product = $this->getById($productId);
        $newProductName = $request->get('productName');
        $newProductDescription = $request->get('productDescription');
        $product->setDescription($newProductDescription);
        $product->setName($newProductName);
        $this->save($product);
        return new Response(self::SUCCESS);
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
     * @param $productId
     * @Route("/product/{productId}", name="product_show")
     * defaults={"ch"="...."}, name="search_parameter")
     * @return Response
     */
    public function productPage(Request $request, $productId)
    {
        $parameter = false;
        if ($request->isMethod($request::METHOD_GET)) {
            $parameter = $request->query->get("ch");
        }
        $product = $this->getById($productId);
        $photos = $product->getPhotos();
        $photoLink = "";
        if (count($photos) > 0) {
            foreach ($photos as $key => $value) {
                $photoLink = '/' . $value;
                break;
            }
        }
        $record = $this->getRecordAboutProduct($productId);
        $user = $this->getUserByRequest($request);
        $isCanChanges = $user &&
            $record &&
            (strcasecmp($record->getUserId(), $user->getId()) == 0);
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
            'is_liked' => $this->isMarked($request, $productId),
            'comments_list' => $this->prepareComments($productId),
            'is_logging' => $this->isUserAuthorization($request),
            'is_changes' => $parameter,
            'is_can_change' => $isCanChanges
        );
        return $this->render(self::PRODUCT_TEMPLATE, $arr);
    }

    private function getRecordAboutProduct($productId) {
        $record = $this
            ->getManager()
            ->getRepository(self::CREACTED_PRODUCT_REPOSITORY)
            ->findBy(["productId" => $productId]);
        return array_shift($record);
    }

    /**
     * @param $request
     * @return boolean
     */
    private function isUserAuthorization ($request) {
        return $this->getUserByRequest($request) ? true : false;
    }

    /**
     * @param $productId
     * @return mixed
     */
    private function prepareComments($productId) {
        $comments =  $this
            ->getManager()
            ->getRepository(self::COMMENT_REPOSITORY)
            ->getByProductId($productId);

        $listComments = [];
        foreach ($comments as $value) {
            $users = $this->getManager()
                ->getRepository(self::USER_REPOSITORY)
                ->findBy(["_id" => $value->getUserId()]);
            $user = $users[0];
            $commentBody = [
                'user_avatar' => $user->getAvatar() == null ? "" :
                    '/' . $this->getParameter(self::PHOTOS_DIRECTORY) . '/' . $user->getAvatar(),
                'user_nickname' => $user->getNickname(),
                'message' => $value->getMessage(),
                'date' => $value->getDate()->format(self::DATE_FORMAT)
            ];
            array_push($listComments, $commentBody);
        }
        return $listComments;
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
        $user = $this->getUserByRequest($request);
        if (!$user) {
            return $this->redirectToRoute(self::HOMEPAGE);
        }
        $product = new Product();
        date_default_timezone_set(self::UTC);
        $categories = $this->getAllCategories();
        $form = $this->get(self::FORM_FACTORY)->create(CreateProductType::class, $product,
                                                    array('categories' => $this->processCategories($categories)));
        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->processCharacteristicsList($product);
                $this->uploadFiles($product);
                $product->setDate(new \MongoDate(strtotime(date(self::DATE_FORMAT))));
                $this->save($product);
                $this->createRecord($user->getId(), $product->getId());
                return $this->redirectToRoute(self::PERSONAL_ROUTE);
            }
        }
        $arr = array('form' => $form->createView());
        return $this->render(self::CREATE_PRODUCT_TEMPLATE, $arr);
    }

    /**
     * @param $userId
     * @param $productId
     */
    private function createRecord($userId, $productId) {
        $record = new CreatedProduct();
        $record->setUserId($userId);
        $record->setProductId($productId);
        $this->save($record);
    }

    /**
     * @param $product Product
     */
    private function uploadFiles($product) {
        $photos = $product->getPhotos();
        $outPhotos = array();
        for ($i = 0; $i < count($photos); $i++){
            $file = $photos[$i];
            $fileName = md5(uniqid()). '.'. $file->guessExtension();
            $file->move(
                $this->getParameter(self::PHOTOS_DIRECTORY),
                $fileName
            );
            array_push($outPhotos, $this->getParameter(self::PHOTOS_DIRECTORY). "\\". $fileName);
        }
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
