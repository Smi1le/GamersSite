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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class PersonalAreaController extends DefaultController
{

    const SECURITY_FIREWALL = 'main';
    const HOMEPAGE = '/';
    /**
     * @Method({"GET", "POST"})
     * @Route("/personal", name="login")
     * @param Request $request
     * @return mixed
     */
    public function loginAction(Request $request)
    {
        $user = new User();

        $loginForm = $this->createForm(LoginType::class, $user);
        $registrationForm = $this->createForm(RegistrationType::class, $user);
        $user = $this->getUserByRequest($request);
        if ($user) {
            $arr = array("login" => $user->getLogin(),
                "email" => $user->getEmail(),
                "nickname" => $user->getNickname(),
                "liked_product_list" => array(
                    array("href" => "http://betshappy.ru")
                ));
            $this->addHeaderLink($arr);
            return $this->render('AcmeStoreBundle:Default:personal_area.html.twig',
                                 $arr);
            return $this->getContentForAuthtorizationUser($user);
        }
        if ($request->isMethod($request::METHOD_POST)) {
            $loginForm->handleRequest($request);
            $registrationForm->handleRequest($request);
            echo "</br>:fggkihjkglh";
            if ($registrationForm->isValid()) {
                echo "</br>:fggkihjkglh";
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPassword());
                echo "</br>:fggkihjkglh";
                $user->setPassword($password);
                echo "</br>:fggkihjkglh";
                $em = $this->get("doctrine_mongodb")->getManager();
                $em->persist($user);
                $em->flush();
                print_r($user);
                $token = new UsernamePasswordToken($user, null, self::SECURITY_FIREWALL, $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $user->setToken($token);
                $em->persist($user);
                $em->flush();

                setcookie("UserId", $user->getId(), time()+86400);
                return $this->getContentForAuthtorizationUser($user);
            }

            if ($loginForm->isValid()) {
                return $this->getContentForAuthtorizationUser($user);
            }
        }
        return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig',
                             $this->prepareContent($registrationForm, $loginForm));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @param $user User
     * @return Response Response
     */
    private function getContentForAuthtorizationUser($user) {
        $arr = array("login" => $user->getLogin(),
            "email" => $user->getEmail(),
            "nickname" => $user->getNickname(),
            "liked_product_list" => array(
                array("href" => "http://betshappy.ru")
            ));
        $this->addHeaderLink($arr);
        $response = $this->render('AcmeStoreBundle:Default:personal_area.html.twig',
                             $arr);
        return $response;
    }

    private function prepareContent($form, $form1) {
        $arr = array('form_reg' => $form->createView(), 'form_auth' => $form1->createView(), 'title_name' => "Registration",
            "Placeholder_search" => "Поиск",
            "autorization_title" => "Авторизация",
            "registration_title" => "Регистрация",
            "entering_button" => "Войти",
            "error_message" => "",
            "forgotten_password" => "Забыли пароль",
            'categories' => $this->getListCategories());
        $arr = $this->addHeaderLink($arr);
        return $arr;
    }

    private function processAuthorizationRequest($enquiry, $form1, $form) {
        $users = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository("AcmeStoreBundle:User")
            ->getByLogin($enquiry->getLogin());
        if (count($users) == 0) {
            $array = $this->prepareLoginContent($form1, $form);
            $array["error_message"] = "User not found";
            $form = $this->createForm(LoginType::class, $enquiry);
            $form1 = $this->createForm(RegistrationType::class, $enquiry);
            return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig',
                                 $array);
        }
        $user = array_shift($users);

        return $user;
    }

    /**
     * @Method("POST")
     * @Route("/exit", name="Exit")
     * @return mixed
     */
    public function exitAtAccount() {
        $answer = setcookie("UserId", "0", time()-86400);
        return $answer ?
            new Response("Exit") :
            new Response("Not exit");
    }
}