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
    const LOGIN = 'login';
    const USER_REPOSITORY = 'AcmeStoreBundle:User';
    const AUTHORIZATION_PAGE = 'AcmeStoreBundle:Default:autorization_page.html.twig';

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
            return $this->redirectToRoute(self::PERSONAL_ROUTE);
        }
        if ($request->isMethod($request::METHOD_POST)) {
            $loginForm->handleRequest($request);
            if ($loginForm->isValid()) {
                $findingUsers = $this->searchUsers($user);
                return $this->searchUserInList($findingUsers, $user);
            }
        }
        return $this->render(self::AUTHORIZATION_PAGE,
                             $this->prepareContent($loginForm));
    }

    /**
     * @param User $user
     * @return mixed
     */
    private function searchUsers($user) {
        return $this->getManager()->getRepository(self::USER_REPOSITORY)
            ->findBy([self::LOGIN => $user->getLogin()]);
    }

    private function searchUserInList($findingUsers, $user) {
        foreach ($findingUsers as $us) {
            if (strcasecmp($user->getPassword(), $us->getPlainPassword()) == 0) {
                $this->setUserIdInCookie($us->getId());
                return $this->redirectToRoute(self::PERSONAL_ROUTE);
            }
        }
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
}