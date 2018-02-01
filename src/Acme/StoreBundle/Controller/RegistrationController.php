<?php
/**
 * Created by PhpStorm.
 * User: Тима
 * Date: 01.02.2018
 * Time: 19:42
 */

namespace Acme\StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\LoginType;
use Acme\StoreBundle\Form\RegistrationType;

class RegistrationController extends DefaultController
{


    /**
     * @Method({"GET", "POST"})
     * @Route("/registration", name="registration")
     * @param Request $request
     * @return mixed
     */
    public function registrationAction(Request $request) {
        $user = new User();
        $registrationForm = $this->createForm(RegistrationType::class, $user);
        if ($request->isMethod($request::METHOD_POST)) {
            $registrationForm->handleRequest($request);
            if ($registrationForm->isValid()) {
                $this->encodePassword($user);
                $this->save($user);
                $this->setUserIdInCookie($user->getId());
                return $this->redirectToRoute(self::PERSONAL);
            }
        }
        return $this->render('AcmeStoreBundle:Default:registration_page.html.twig',
                             $this->prepareContent($registrationForm));
    }

    /*private function processAuthorizationRequest($enquiry, $form1, $form) {
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
    }*/
}