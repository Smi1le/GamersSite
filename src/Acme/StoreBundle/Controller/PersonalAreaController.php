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
    const HOMEPAGE = 'default_show';
    const PERSONAL = 'personal';

    /**
     * @Method({"GET", "POST"})
     * @Route("/personal", name="personal")
     * @param Request $request
     * @return mixed
     */
    public function personalArea(Request $request)
    {
        $user = $this->getUserByRequest($request);
        if ($user) {
            return $this->preparePersonalAreaContent($user);
        }
        return $this->redirectToRoute(self::HOMEPAGE);
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