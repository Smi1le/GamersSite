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
    const REGISTRATION_TEMPLATE = 'AcmeStoreBundle:Default:registration_page.html.twig';

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
                return $this->redirectToRoute(self::PERSONAL_ROUTE);
            }
        }
        return $this->render(self::REGISTRATION_TEMPLATE, $this->prepareContent($registrationForm));
    }
}