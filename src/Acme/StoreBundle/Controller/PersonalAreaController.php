<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 25.11.2017
 * Time: 17:52
 */

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\AcmeStoreBundle;
use Acme\StoreBundle\Document\IncomingUser;
use Acme\StoreBundle\Document\LikedRecord;
use Acme\StoreBundle\Document\Product;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\LoginType;
use Acme\StoreBundle\Form\RegistrationType;
use Acme\StoreBundle\Entity\RegistrationTask;
use Acme\StoreBundle\Form\UploadPersonalPhoto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\StoreBundle\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Acme\StoreBundle\Document\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class PersonalAreaController extends DefaultController
{

    const SECURITY_FIREWALL = 'main';
    const PERSONAL = 'personal';
    const EXIT_SUCCESS = 'exit';
    const EXIT_FAILURE = 'not exit';
    const ABSTRACT_USER_ID = '0';

    /**
     * @Method({"GET", "POST"})
     * @Route("/personal", name="personal")
     * @param Request $request
     * @return mixed
     */
    public function personalArea(Request $request)
    {
        $file = new UploadedFile();
        $form = $this->createForm(UploadPersonalPhoto::class, $file);
        $user = $this->getUserByRequest($request);
        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->uploadPhoto($file, $user);
            }
        }
        if ($user) {
            return $this->preparePersonalAreaContent($user, $form->createView());
        }
        return $this->redirectToRoute(self::HOMEPAGE);
    }

    private function uploadPhoto($fileForm, $user) {
        $file = $fileForm->getPath();
        $fileName = md5(uniqid()). '.'. $file->guessExtension();
        $file->move(
            $this->getParameter(self::PHOTOS_DIRECTORY),
            $fileName
        );
        $user->setAvatar($fileName);
        $this->save($user);
    }

    /**
     * @Method({"POST"})
     * @param Request request
     * @Route("/personal/update/{fieldName}/{newValue}")
     * @return mixed
     */
    public function updateAccountInfo(Request $request, $fieldName, $newValue) {
        $user = $this->getUserByRequest($request);
        return new Response($this->changeFieldValueUser($user, $fieldName, $newValue));
    }

    /**
     * @param User $user
     * @param string $fieldName
     * @param string $newValue
     * @return mixed
     */
    private function changeFieldValueUser($user, $fieldName, $newValue) {
        if (strcasecmp('login', $fieldName) == 0) {
            $user->setLogin($newValue);
        } else if (strcasecmp('email', $fieldName) == 0) {
            $user->setEmail($newValue);
        } else if (strcasecmp('nickname', $fieldName) == 0) {
            $user->setNickname($newValue);
        }
        $this->save($user);
        return self::SUCCESS;
    }


    /**
     * @Method("POST")
     * @Route("/exit", name="Exit")
     * @return mixed
     */
    public function exitAtAccount() {
        $answer = $this->removeUserIdInCookie(self::ABSTRACT_USER_ID);
        return $answer ?
            new Response(self::EXIT_SUCCESS) :
            new Response(self::EXIT_FAILURE);
    }


    /**
     * @param $user User
     * @return Response Response
     */
    private function preparePersonalAreaContent($user, $formView) {
        $arr = array(
            'form' => $formView,
            "login" => $user->getLogin(),
            "email" => $user->getEmail(),
            'categories' => $this->getListCategories(),
            "nickname" => $user->getNickname(),
            'avatar' => $user->getAvatar() == null ? "" :
                $this->getParameter(self::PHOTOS_DIRECTORY) . '/' . $user->getAvatar(),
            'liked_product_list' => $this->getProductListWhichUserLike($user),
            'added_product_in_site' => $this->prepareAddedProduct($user));

        return $this->render(self::PERSONAL_AREA_TEMPLATE, $arr);
    }

    /**
     * @param User $user
     * @return array
     */
    private function prepareAddedProduct($user) {
        $records = $this->getManager()->getRepository(self::CREACTED_PRODUCT_REPOSITORY)->findBy(["userId" => $user->getId()]);
        $preparingProducts = [];
        foreach ($records as $value) {
            $product = $this->prepareProductBeforeImpact($value);
            if ($product != null) {
                array_push($preparingProducts, $product);
            }
        }
        return $preparingProducts   ;
    }

    /**
     * @param User $user
     * @return array
     */
    private function getProductListWhichUserLike($user) {
        $records = $this->getRecordByUserId($user);
        $listProducts = [];
        foreach ($records as $value) {
            $product = $this->prepareProductBeforeImpact($value);
            if ($product != null) {
                array_push($listProducts, $product);
            }
        }
        return $listProducts;
    }

    /**
     * @param User $user
     * @return mixed
     */
    private function getRecordByUserId($user) {
        return $this->getManager()
            ->getRepository(self::LIKED_PRODUCT_REPOSITORY)
            ->findByUserId($user->getId());
    }

    /**
     * @param LikedRecord $likedProduct
     * @return array
     */
    private function prepareProductBeforeImpact($likedRecord) {
        $product = $this
            ->getManager()
            ->getRepository(self::PRODUCT_REPOSITORY)
            ->findOneBy(['_id' => $likedRecord->getProductId()]);

        if (!$product) {
            return null;
        }
        $item['page_link'] = $this->createPathToProduct($product);
        $item['photo_path'] = $this->createPathToPreviewProduct($product);
        $item['name'] = $product->getName();
        return $item;
    }

    /**
     * @param Product $product
     * @return string
     */
    private function createPathToProduct($product) {
        return '/product/' . $product->getId();
    }

    /**
     * @param Product $product
     * @return string
     */
    private function createPathToPreviewProduct($product) {
        $photo = count($product->getPhotos()) === 0 ? "" : $product->getPhotos()[0];
        return $photo == "" ? "" : '/' . $photo;
    }
}