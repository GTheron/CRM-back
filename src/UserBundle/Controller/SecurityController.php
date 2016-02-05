<?php

namespace Core\UserBundle\Controller;
use Asi\BillBundle\Event\RequestEvent;
use Core\UserBundle\CoreUserBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

/**
 * Class SecurityController
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\Controller
 */
class SecurityController extends Controller
{
    /** /!\ Non utilisé !! /!\  **/

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        //var_dump($error);

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $event=new RequestEvent($request);
        $this->get('event_dispatcher')->dispatch(CoreUserBundle::USER_LOGGED_IN,$event);

        return $this->render(
            'CoreUserBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    public function loginCheckAction()
    {
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}