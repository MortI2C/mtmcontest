<?php

namespace IBM\MTMBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use IBM\MTMBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Templating\EngineInterface;
use IBM\MTMBundle\Form\CustomerType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Router;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use IBM\MTMBundle\Entity\Balance;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use IBM\MTMBundle\Entity\Users;
use Symfony\Component\Validator\Constraints\NotBlank;
use IBM\MTMBundle\Form\UsersType;

class UsersService {
	
	/**
	 * 
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * 
	 * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
	 */
	private $templating;
	
	/**
	 * 
	 * @var \Symfony\Component\HttpFoundation\Session\Session
	 */
	private $session;
	
	/**
	 * @var \Symfony\Component\Form\FormFactory
	 */
	private $formFactory;
	
	/**
	 * @var \Symfony\Component\Routing\Router 
	 */
	private $router;
	
	/**
	 * 
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 */
	public function __construct(\Doctrine\ORM\EntityManager $entityManager, 
			\Symfony\Component\HttpFoundation\Session\Session $session, 
			\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating, 
			\Symfony\Component\Form\FormFactory $formFactory,
			\Symfony\Component\Routing\Router $router)
	{
		$this->em = $entityManager;
		$this->session = $session;
		$this->templating = $templating;
		$this->formFactory = $formFactory;
		$this->router = $router;
	}

	public function createUser(Request $request, \Symfony\Component\Security\Core\Encoder\EncoderFactory $factory)
	{
		$user =  new Users();
		$form = $this->formFactory->create(new UsersType(), $user, array('action' => $this->router->generate('users_create')));
		if($request->isMethod("POST")) {
			$form->bind($request);
				
			$entities = $this->em->getRepository('IBMMTMBundle:Users')
				->findByUsername($user->getUsername());
			if($entities) {
				$form->get('account')->addError(new FormError('This username already exists!'));
			}
			
			if($user->getRole()=='ROLE_CUSTOMER' && $user->getCustomer()==null)
			{
				$form->get('customer')->addError(new FormError('Role customer needs a customer entity assigned!'));
			}
			
			if($form->isValid())
			{
				$password = $form->get('password')->getData();
				$encoder = $factory->getEncoder($user);
				mt_srand(microtime(true)*100000 + memory_get_usage(true));
				$user->setSalt(md5(uniqid(mt_rand(), true)));			
				$user->setPassword($encoder->encodePassword($password,$user->getSalt()));
				
				$this->em->persist($user);
				$this->em->flush();
				
				$this->session->getFlashBag()->add('success','The new user has been created');
				return new RedirectResponse($this->router->generate('users'));
			}
		}
		
		return $this->templating->renderResponse('IBMMTMBundle:Users:new.html.twig', array('form' => $form->createView()));
	}
	
	public function deleteUser(Request $request, $id) 
	{
		$entities = $this->em->getRepository('IBMMTMBundle:Users')
			->findById($id);
		if(!$entities) {
			$this->session->getFlashBag()->add('error','The user does not exist');
			return new RedirectResponse($this->router->generate('users'));
		}
		
		$user = array_shift($entities);
		
		$this->em->remove($user);
		$this->em->flush();
		
		$this->session->getFlashBag()->add('success','The user has been deleted');
		return new RedirectResponse($this->router->generate('users'));
	}
	
	public function editUser(Request $request, $id, \Symfony\Component\Security\Core\Encoder\EncoderFactory $factory)
	{
		$entities = $this->em->getRepository('IBMMTMBundle:Users')->findById($id);
		if(!$entities) 
		{
			$this->session->getFlashBag()->add('error','The user does not exist!');
			return new RedirectResponse($this->router->generate('users'));
		}
		
		$user = array_shift($entities);
		$form = $this->formFactory->create(new UsersType(true), $user, array('action' => $this->router->generate('users_edit', array('id' => $id))));
		$oldPassword = $user->getPassword();
		if($request->isMethod("POST")) {
			$form->bind($request);
			if($user->getRole()=='ROLE_CUSTOMER' && $user->getCustomer()==null)
			{
				$form->get('customer')->addError(new FormError('Role customer needs a customer entity assigned!'));
			}

			if($form->isValid()) {
				exit('hello');
				$password = $form->get('password')->getData();
				$encoder = $factory->getEncoder($user);
				if($password != "") {
					mt_srand(microtime(true)*100000 + memory_get_usage(true));
					$user->setSalt(md5(uniqid(mt_rand(), true)));
					$user->setPassword($encoder->encodePassword($password,$user->getSalt()));
				} else
					$user->setPassword($oldPassword);	
					
				$this->em->persist($user);
				$this->em->flush();
					
				$this->session->getFlashBag()->add('success','The user has been updated');
			}
		}
		
		return $this->templating->renderResponse('IBMMTMBundle:Customer:edit.html.twig',array('user' => $user, 'form' => $form->createView()));
	}

}

?>