<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\User;
use MongoDB\BSON\ObjectID;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    const SUCCESS = 'OK';
    const USER_ID = 'UserId';
    const HOMEPAGE = 'default_show';
    const COOKIE_TIME_LIMIT = 86400;
    const PERSONAL_ROUTE = 'personal';
    const DOCTRINE = 'doctrine_mongodb';
    const PHOTOS_DIRECTORY = 'avatars_directory';
    const USER_REPOSITORY = 'AcmeStoreBundle:User';
    const CREACTED_PRODUCT_REPOSITORY = 'AcmeStoreBundle:CreatedProduct';
    const PRODUCT_REPOSITORY = 'AcmeStoreBundle:Product';
    const CATEGORY_REPOSITORY = 'AcmeStoreBundle:Category';
    const LIKED_PRODUCT_REPOSITORY = 'AcmeStoreBundle:LikedRecord';
    const COMMENT_REPOSITORY = 'AcmeStoreBundle:Comment';
    const PASSWORD_ENCODER = 'security.password_encoder';
    const PERSONAL_AREA_TEMPLATE = 'AcmeStoreBundle:Default:personal_area.html.twig';

    protected function getManager() {
        return $this
            ->get(self::DOCTRINE)
            ->getManager();
    }

    protected function save($object) {
        $manager = $this->getManager();
        $manager->persist($object);
        $manager->flush();
    }

    protected function remove($value) {
        $manager = $this->getManager();
        $manager->remove($value);
        $manager->flush();
    }

    /**
     * @param $userId
     */
    protected function setUserIdInCookie($userId) {
        setcookie(self::USER_ID, $userId, time()+self::COOKIE_TIME_LIMIT);
    }

    /**
     * @param string $userId
     * @return bool
     */
    protected function removeUserIdInCookie($userId) {
        return setcookie(self::USER_ID, $userId, time()-self::COOKIE_TIME_LIMIT);
    }


    protected function getUserByRequest(Request $request) {
        if (isset($_COOKIE[self::USER_ID])) {
            $id = $_COOKIE[self::USER_ID];
            $user = $this->get(self::DOCTRINE)
                ->getManager()
                ->getRepository(self::USER_REPOSITORY)
                ->findBy(['_id' => $id]);
            return count($user) > 0 ? $user[0] : null;
        }
        return null;

    }

    /**
     * @param Form $form
     * @return array
     */
    protected function prepareContent(Form $form) {
        $arr = array('form' => $form->createView(), 'title_name' => "Registration",
            "Placeholder_search" => "Поиск",
            "autorization_title" => "Авторизация",
            "registration_title" => "Регистрация",
            "entering_button" => "Войти",
            "error_message" => "",
            "forgotten_password" => "Забыли пароль",
            'categories' => $this->getListCategories());
        return $arr;
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    protected function getProducts() {
        return $this
            ->getManager()
            ->getRepository(self::PRODUCT_REPOSITORY)
            ->findSortedByDate();
    }

    /**
     * Encoding user password
     *
     * @param User $user
     * @return User
     */
    protected function encodePassword($user) {
        $password = $this->get(self::PASSWORD_ENCODER)
            ->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
    }

    protected function getListCategories() {
        $categories = $this->getCategories();
        $newList = array();
        foreach ($categories as $category) {
            $newCategory = array(
                'name' => $category->getNameRu(),
                'href' => '/catalog/' . strtolower(str_replace(' ', '_', $category->getNameEn()))
            );
            array_push($newList, $newCategory);
        }
        return $newList;
    }

    private function getCategories() {
        return $this
            ->get(self::DOCTRINE)
            ->getManager()
            ->getRepository(self::CATEGORY_REPOSITORY)
            ->findSortedByName();
    }
}
