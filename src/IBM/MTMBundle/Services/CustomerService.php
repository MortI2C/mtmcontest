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

class CustomerService {
	
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
	
	public function setCustomerStatus($account)
	{
		$returnString = 'activated';
		$customer = $this->em->getRepository('IBMMTMBundle:Customer')->findOneByAccount($account);
		if($customer->getStatus() == 'I')
			$customer->setStatus('A');
		else {
			$customer->setStatus('I');
			$returnString = 'deactivated';
		}
		
		$this->em->persist($customer);
		$this->em->flush();
		
		return $returnString;
	}

	public function createUser(Request $request)
	{
		$customer =  new Customer();
		$form = $this->formFactory->create('customer_type', $customer, array('action' => $this->router->generate('customer_create')));
		$form->bind($request);
		
		$entities = $this->em->getRepository('IBMMTMBundle:Customer')
			->findByAccount($customer->getAccount());
		if($entities) {
			$form->get('account')->addError(new FormError('This account number already exists!'));
		}
		
		if($form->isValid())
		{
			$this->em->persist($customer);
			$this->em->flush();
			
			$this->session->getFlashBag()->add('success','The new customer has been created');
			return new RedirectResponse($this->router->generate('customer'));
		}
		
		return $this->templating->renderResponse('IBMMTMBundle:Customer:new.html.twig', array('form' => $form->createView()));
	}

}

?>