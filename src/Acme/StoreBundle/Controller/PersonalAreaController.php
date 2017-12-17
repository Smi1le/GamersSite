<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 25.11.2017
 * Time: 17:52
 */

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\AcmeStoreBundle;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\LoginType;
use Acme\StoreBundle\Form\RegistrationType;
use Acme\StoreBundle\Entity\RegistrationTask;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Acme\StoreBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class PersonalAreaController extends DefaultController
{

    /**
     * @Method({"POST"})
     * @Route("/lk1")
     */
//    public function createUser(Request $request) {
//        $error = "";
//        if (! strcasecmp($request->get("password"), $request->get("password_repeat"))) {
//            $error = "password error";
//        }
//        $user = new User();
//        $user->setEmail($request->get("login_email"));
//        $user->setPassword($request->get("password"));
//        $this->save($user);
//        return new Response('Created product id '. $request);
//    }

    /**
     * @Route("/lk1", name="lk_show1")
     */
//    public function lk1() {
//        $arr = array(
//            "title_name" => "My New Page",
//            "Placeholder_search" => "Поиск",
//            "boot_template" => "main_content.html.twig",
//            "catalog_title" => "Каталог",
//            "last_added_title" => "Последние добавления",
//            "margin_top_footer" => "2000px",
//            "login_text" => "Логин",
//            "autorization_title" => "Авторизация",
//            "registration_title" => "Регистрация",
//            "login_password_repeat" => "Повторите пароль",
//            "login_email" => "email",
//            "login_nickneim" => "Введите никнейм",
//            "login_password" => "Пароль",
//            "entering_button" => "Войти",
//            "error_message" => "",
//            "forgotten_password" => "Забыли пароль",
//            "sidebar_elements" => array(array("page_link" => "https://vk.com/na_fokse", "name" => "You Father")));
//        $arr = $this->addHeaderLink($arr);
//
//        // print_r($arr);
//        return $this->render('AcmeStoreBundle:Default:registration_page.html.twig', $arr);
//    }





    /**
     * @Route("/lk", name="lk_show")
     */
//    public function lk() {
//        $arr = array(
//            "title_name" => "My New Page",
//            "Placeholder_search" => "Поиск",
//            "boot_template" => "main_content.html.twig",
//            "catalog_title" => "Каталог",
//            "last_added_title" => "Последние добавления",
//            "margin_top_footer" => "2000px",
//            "login_text" => "Логин",
//            "autorization_title" => "Авторизация",
//            "registration_title" => "Регистрация",
//            "login_password_repeat" => "Повторите пароль",
//            "login_email" => "email",
//            "login_nickneim" => "Введите никнейм",
//            "login_password" => "Пароль",
//            "entering_button" => "Войти",
//            "error_message" => "",
//            "forgotten_password" => "Забыли пароль",
//            "sidebar_elements" => array(array("page_link" => "https://vk.com/na_fokse", "name" => "You Father")));
//        $arr = $this->addHeaderLink($arr);
//
//        // print_r($arr);
//        return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig', $arr);
//    }

//    private $encoder;
//
//
//    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
//        $this->encoder = $passwordEncoder;
//    }


    /**
     * @Method({"GET", "POST"})
     * @Route("/registration", name="AcmeStoreBundle_personalArea")
     * @param Request $request
     * @return mixed
     */
    public function personalAreaAction(Request $request) {
        $enquiry = new User();

        $form = $this->createForm(RegistrationType::class, $enquiry);
        $form1 = $this->createForm(LoginType::class, $enquiry);


        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $enquiry->setPassword($enquiry->getPlainPassword());

                $this->save($enquiry);

                return $this->redirect($this->generateUrl('AcmeStoreBundle_personalArea'));
            }
        }

        $arr = array('form_reg' => $form->createView(), 'form_auth' => $form1->createView(), 'title_name' => "Registration",
            "Placeholder_search" => "Поиск",
            "autorization_title" => "Авторизация",
            "registration_title" => "Регистрация",
            "entering_button" => "Войти",
            "error_message" => "",
            "registration" => true,
            "forgotten_password" => "Забыли пароль");
        $arr = $this->addHeaderLink($arr);
        return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig', $arr);
    }


    /**
     * @Method({"GET", "POST"})
     * @Route("/login", name="AcmeStoreBundle_login")
     * @param Request $request
     * @return mixed
     */
    public function loginAction(Request $request) {
        $enquiry = new User();

        $form = $this->createForm(LoginType::class, $enquiry);
        $form1 = $this->createForm(RegistrationType::class, $enquiry);

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);

            if ($form->isValid()) {
//                $login = $request->get("login");
                $password = $request->getPassword();


                $users = $this->get('doctrine_mongodb')
                    ->getManager()
                    ->getRepository("AcmeStoreBundle:User")
                    ->getByLogin($enquiry->getPassword());

//                $enquiry->setPassword($enquiry->getPlainPassword());

//                $this->save($enquiry);
                $result = '';
//                $this->container->get('request')->getClientIp();
//                foreach ( $users  as  $user )  {
//                    $result = $result . $user->getLogin() . "\n" ;
//}

                return new Response($request->getClientIp());
            }
        }

        $arr = array('form_auth' => $form->createView(), 'form_reg' => $form1->createView(), 'title_name' => "Login",
            "Placeholder_search" => "Поиск",
            "autorization_title" => "Авторизация",
            "registration_title" => "Регистрация",
            "entering_button" => "Войти",
            "error_message" => "",
            "registration" => false,
            "forgotten_password" => "Забыли пароль");
        $arr = $this->addHeaderLink($arr);
        return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig', $arr);
    }



}