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

	public function createCustomer(Request $request, \Symfony\Component\Security\Core\Encoder\EncoderFactory $factory)
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
			$balanceData = $form->get('balance')->getData();
			$this->em->persist($customer);
			
			$balance = new Balance();
			$balance->setAccount($customer->getAccount());
			$balance->setCustomer($customer);
			$balance->setBalance($balanceData);
			$this->em->persist($balance);
			
			$user = new Users();
			$email = $form->get('email')->getData();
			$password = $form->get('password')->getData();
			$encoder = $factory->getEncoder($user);
			mt_srand(microtime(true)*100000 + memory_get_usage(true));
			$user->setSalt(md5(uniqid(mt_rand(), true)));			
			$user->setPassword($encoder->encodePassword($password,$user->getSalt()));
			$user->setRole('ROLE_CUSTOMER');
			$user->setUsername($customer->getAccount());
			$user->setEmail($email);
			$user->setCustomer($customer);
			
			$this->em->persist($user);
			$this->em->flush();
			
			$this->session->getFlashBag()->add('success','The new customer has been created');
			return new RedirectResponse($this->router->generate('customer'));
		}
		
		return $this->templating->renderResponse('IBMMTMBundle:Customer:new.html.twig', array('form' => $form->createView()));
	}
	
	public function deleteCustomer(Request $request, $account) 
	{
		if(strlen($account) != 12 || !preg_match('~^\d{12}$~', $account)) {
			$this->session->getFlashBag()->add('error','An error has occurred');
			return new RedirectResponse($this->router->generate('customer'));
		}
		
		$entities = $this->em->getRepository('IBMMTMBundle:Customer')
			->findByAccount($account);
		if(!$entities) {
			$this->session->getFlashBag()->add('error','The account does not exist');
			return new RedirectResponse($this->router->generate('customer'));
		}
		
		$customer = array_shift($entities);
		if($customer->getBalance() != null)
		   $this->em->remove($customer->getBalance());
		if($customer->getPin() != null)
	       $this->em->remove($customer->getPin());
		
		$trans = $this->em->getRepository('IBMMTMBundle:Trans')
			->findByCustomer($customer);
		foreach($trans as $transaction) {
			//$transaction->setCustomer(null);
			$em->remove($transaction);
		}
		
		$users = $this->em->getRepository('IBMMTMBundle:Users')
			->findByCustomer($customer);
		foreach($trans as $user)
			$this->em->remove($user);
		
		$this->em->remove($customer);
		$this->em->flush();
		
		$this->session->getFlashBag()->add('success','The account has been deleted');
		return new RedirectResponse($this->router->generate('customer'));
	}
	
	public function editCustomer(Request $request, $account)
	{
		$entities = $this->em->getRepository('IBMMTMBundle:Customer')->findByAccount($account);
		if(!$entities) 
		{
			$this->session->getFlashBag()->add('error','The customer does not exist!');
			return new RedirectResponse($this->router->generate('customer'));
		}
		$customer = array_shift($entities);
		$form = $this->formFactory->create(new CustomerType(true), $customer, array('action' => $this->router->generate('customer_edit', array('account' => $account))));
		$oldBalance = $customer->getBalance()->getBalance();
		if($request->isMethod("POST")) {
			$form->bind($request);
			if($form->isValid()) {
				$balance = $form->get('balance')->getData();
				if($balance != $oldBalance) {
					$customer->getBalance()->setBalance($balance);
				}
					
				$this->em->persist($customer);
				$this->em->flush();
					
				$this->session->getFlashBag()->add('success','The user has been updated');
			}
		} else {
			$form->add('balance', 'number', array(
					'mapped' => false,
					'required' => true,
					'data' => $oldBalance,
					'precision' => 2,
					'constraints' => array(
							new NotBlank()
					)
			));
		}
		
		return $this->templating->renderResponse('IBMMTMBundle:Customer:edit.html.twig',array('customer' => $customer, 'form' => $form->createView()));
	}

}

?>