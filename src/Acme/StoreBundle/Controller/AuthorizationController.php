<?php

namespace Acme\StoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\LoginType;

class AuthorizationController extends DefaultController
{
    const PERSONAL = 'personal';

    /**
     * @Method({"GET", "POST"})
     * @Route("/login", name="login")
     * @param Request $request
     * @return mixed
     */
    public function loginAction(Request $request)
    {
        $user = new User();
        $loginForm = $this->createForm(LoginType::class, $user);

        $userByRequest = $this->getUserByRequest($request);
        if ($userByRequest) {
            return $this->redirectToRoute(self::PERSONAL);
        }
        if ($request->isMethod($request::METHOD_POST)) {
            $loginForm->handleRequest($request);
            if ($loginForm->isValid()) {
                $findingUser = $this->getManager()->getRepository("AcmeStoreBundle:User")
                    ->findBy(['login' => $user->getLogin()]);
                foreach ($findingUser as $us) {
                    $pass = $this->encodePassword($us);
                    if (strcasecmp($pass, $us->getPlainPassword())) {
                        $this->setUserIdInCookie($us->getId());
                        return $this->redirectToRoute(self::PERSONAL);
                    }
                }
            }
        }
        return $this->render('AcmeStoreBundle:Default:autorization_page.html.twig',
                             $this->prepareContent($loginForm));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
}