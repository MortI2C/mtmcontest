<?php

namespace IBM\MTMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$curRole = $this->getUser()->getRole();
    	if($curRole == 'ROLE_ADMIN' || $curRole == 'ROLE_MANAGER')
          return $this->render('IBMMTMBundle:Default:backend_index.html.twig');
    	else
    	  return $this->render('IBMMTMBundle:Default:atm_index.html.twig');
    }
    
    public function loginAction()
    {
		$request = $this->getRequest ();
		$session = $request->getSession ();
		
		if ($request->attributes->has ( SecurityContext::AUTHENTICATION_ERROR )) {
			$error = $request->attributes->get ( SecurityContext::AUTHENTICATION_ERROR );
		} else {
			$error = $session->get ( SecurityContext::AUTHENTICATION_ERROR );
			$session->remove ( SecurityContext::AUTHENTICATION_ERROR );
		}
		
		$lastUsername = $session->get ( SecurityContext::LAST_USERNAME );
		$lastUsername = ($lastUsername) ? $lastUsername : 'Usuari';
		
		return $this->render ( 'IBMMTMBundle:Default:login.html.twig', array (
				// last username entered by the user
				'last_username' => $lastUsername,
				'error' => $error 
		) ); 
    }
    
    public function forgotPasswordAction()
    {
    	return $this->render('IBMMTMBundle:Default:forgot_password.html.twig');
    }
}
