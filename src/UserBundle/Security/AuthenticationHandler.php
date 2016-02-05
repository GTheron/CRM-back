<?php

namespace Core\UserBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


/**
 * Class AuthenticationHandler
 *
 * @author Gabriel Théron <gabriel@class-web.fr>
 * @copyright Class Web 2015
 * @package Core\UserBundle\EventListener
 */
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{	private $router;
    private $session;

    /**
     * Constructor
     *
     * @param 	RouterInterface $router
     * @param 	Session $session
     */
    public function __construct( RouterInterface $router, Session $session )
    {
        $this->router  = $router;
        $this->session = $session;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // if AJAX login
        if ( $request->isXmlHttpRequest() ) {

            //TODO faire le login ajax
            /*$response = new Response( json_encode( $data ) );
            $response->headers->set( 'Content-Type', 'application/json' );
            */
            return null;
            return $response;

            // if form login
        } else {

            if ( $this->session->get('_security.main.target_path' ) ) {

                $url = $this->session->get( '_security.main.target_path' );

            } else {

                $url = $this->router->generate( 'app_front_home' );

            } // end if

            return new RedirectResponse( $url );

        }
    }
}