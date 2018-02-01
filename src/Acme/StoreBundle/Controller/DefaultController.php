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
    const COOKIE_TIME_LIMIT = 86400;

    protected function getManager() {
        return $this
            ->get("doctrine_mongodb")
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
        setcookie("UserId", $userId, time()+self::COOKIE_TIME_LIMIT);
    }

    /**
     * @param $userId
     */
    protected function removeUserIdInCookie($userId) {
        setcookie("UserId", $userId, time()-self::COOKIE_TIME_LIMIT);
    }


    protected function getUserByRequest(Request $request) {
        if (isset($_COOKIE["UserId"])) {
            $id = $_COOKIE["UserId"];
            $user = $this->get('doctrine_mongodb')
                ->getManager()
                ->getRepository("AcmeStoreBundle:User")
                ->findBy(['_id' => $id]);
            return count($user) > 0 ? $user[0] : null;
        }
        return null;

    }

    /**
     * @param $user User
     * @return Response Response
     */
    protected function preparePersonalAreaContent($user) {
        $arr = array("login" => $user->getLogin(),
            "email" => $user->getEmail(),
            "nickname" => $user->getNickname(),
            "liked_product_list" => array(
                array("href" => "http://betshappy.ru")
            ));
        $response = $this->render('AcmeStoreBundle:Default:personal_area.html.twig',
                                  $arr);
        return $response;
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
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Product')
            ->findSortedByDate();
    }

    /**
     * Encoding user password
     *
     * @param User $user
     * @return User
     */
    protected function encodePassword($user) {
        $password = $this->get('security.password_encoder')
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
            ->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Category')
            ->findSortedByName();
    }
}
