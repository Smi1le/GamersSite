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


class PersonalAreaController extends DefaultController
{
    /**
     * @Method({"GET", "POST"})
     * @Route("/personal", name="personal_area")
     * @param Request $request
     * @return mixed
     */
    public function loginAction(Request $request)
    {
        $enquiry = new IncomingUser();

        $form = $this->createForm(LoginType::class, $enquiry);
        $form1 = $this->createForm(RegistrationType::class, $enquiry);
        $user = $this->getUserById();
        if ($user) {
//            $arr = array("login" => $user->getLogin(),
//                "email" => $user->getEmail(),
//                "nickname" => $user->getNickname(),
//                "liked_product_list" => array(
//                    array("href" => "http://betshappy.ru")
//                ));
//            $this->addHeaderLink($arr);
//            return $this->render('AcmeStoreBundle:Default:personal_area.html.twig',
//                                 $arr);
            return $this->getContentForAuthtorizationUser($user);
        }

        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);
            $form1->handleRequest($request);
            if ($form->isValid() || $form1->isValid()) {
                $user = new User();
                if (strcasecmp("authorization", $enquiry->getType()) == 0) {
                    $user = $this->processAuthorizationRequest($enquiry, $form1, $form);

                } else if (strcasecmp("registration", $enquiry->getType()) == 0){
                    $user = $this->processRegistrationRequest($enquiry);
                }
                $_SESSION["user_id"] = $user->getId();
                return $this->getContentForAuthtorizationUser($user);
            }
        }
        return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig',
                             $this->prepareContent($form1, $form));
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
        return $this->render('AcmeStoreBundle:Default:personal_area.html.twig',
                             $arr);
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

    private function processRegistrationRequest($enquiry) {
        $enquiry->setPassword($enquiry->getPlainPassword());
        $this->save($enquiry);
        $this->createUser($enquiry);
        $users = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository("AcmeStoreBundle:User")
            ->getByLogin($enquiry->getLogin());
        return count($users) > 0 ? array_shift($users) : null;
    }

    private function createUser($enquiry) {
        $user = new User();
        $user->setPassword($enquiry->getPassword());
        $user->setNickname($enquiry->getNickname());
        $user->setLogin($enquiry->getLogin());
        $user->setEmail($enquiry->getEmail());
        $this->save($user);
    }

    /**
     * @Method("POST")
     * @Route("/exit", name="Exit")
     * @return mixed
     */
    public function exitAtAccount() {
        $answer = session_destroy();
        return $answer ?
            new Response("Exit") :
            new Response("Not exit");
    }
}