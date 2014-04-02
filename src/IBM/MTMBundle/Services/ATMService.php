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
use Symfony\Component\Security\Core\SecurityContext;
use IBM\MTMBundle\Entity\Trans;

class ATMService {
	
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
	 * @var \Symfony\Component\Security\Core\SecurityContext
	 */
	private $securityContext;
	
	/**
	 * 
	 * @param \Doctrine\ORM\EntityManager $entityManager
	 */
	public function __construct(\Doctrine\ORM\EntityManager $entityManager, 
			\Symfony\Component\HttpFoundation\Session\Session $session, 
			\Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $templating, 
			\Symfony\Component\Form\FormFactory $formFactory,
			\Symfony\Component\Routing\Router $router,
			\Symfony\Component\Security\Core\SecurityContext $securityContext)
	{
		$this->em = $entityManager;
		$this->session = $session;
		$this->templating = $templating;
		$this->formFactory = $formFactory;
		$this->router = $router;
		$this->securityContext = $securityContext;
	}

	public function index(Request $request) {
		$user = $this->getUser();
		if($user->getCustomer()->getStatus()=='I')
		{
			return $this->templating->renderResponse('IBMMTMBundle:ATM:inactive.html.twig');
		}
		
		$form = $this->formFactory->createBuilder()
			->add('amount', 'number', array(
				'required' => true,
				'mapped' => false,
				'precision' => 2,
				'data' => 0,
				'attr' => array('style' => 'margin-left: .5em;'),
				'constraints' => array(
					new NotBlank()
				)
			))
			->add('Deposit amount','submit',array('attr' => array('value' => 'depositSubmit','class' => 'btn btn-primary', 'style' => 'margin-right: .5em; margin-left: .5em;')))
			->add('Withdraw amount','submit',array('attr' => array('value' => 'withdrawSubmit', 'class' => 'btn btn-success')))
			->setAction($this->router->generate('transaction'))->getForm();
			
		return $this->templating->renderResponse('IBMMTMBundle:ATM:index.html.twig',
				array('user' => $user, 
					 'form' => $form->createView()));
	}
	
	private function getUser() {
		if (null === $token = $this->securityContext->getToken()) {
			return null;
		}
		
		if (!is_object($user = $token->getUser())) {
			return null;
		}
		
		return $user;
	}
	
	public function doTransaction(Request $request) {
		$user = $this->getUser();
		$form = $this->formFactory->createBuilder()
			->add('amount', 'number', array(
				'required' => true,
				'mapped' => false,
				'precision' => 2,
				'data' => 0,
				'attr' => array('style' => 'margin-left: .5em;'),
				'constraints' => array(
					new NotBlank()
				)
			))
			->add('Deposit amount','submit',array('attr' => array('value' => 'depositSubmit','class' => 'btn btn-primary', 'style' => 'margin-right: .5em; margin-left: .5em;')))
			->add('Withdraw amount','submit',array('attr' => array('value' => 'withdrawSubmit', 'class' => 'btn btn-success')))
			->setAction($this->router->generate('transaction'))->getForm();
		
		$form->bind($request);
		if($form->isValid()) {
			$kind = 'D';
			if($form->get('Withdraw amount')->isClicked())
				$kind = 'W';
			
			$amount = $form->get('amount')->getData();
			if($this->createTrans($kind,$amount,$user->getCustomer()))
			{
				$this->session->getFlashBag()->add('success','Transaction successfully completed');
				return new RedirectResponse($this->router->generate('atm'));
			} else 
				$this->session->getFlashBag()->add('error','Unexpected error!');
		}
		
		return $this->templating->renderResponse('IBMMTMBundle:ATM:index.html.twig',
				array('user' => $user,
				'form' => $form->createView()));
	}
	
	private function createTrans($kind, $amount, Customer $customer)
	{
		$amount = ($kind == 'W') ? $amount*=-1 : $amount;
		$trans = new Trans();
		$trans->setType($kind);
		$trans->setCustomer($customer);
		$trans->setAccount($customer->getAccount());
		$trans->setAmount($amount);
		$balance = $customer->getBalance();
		$balance->setBalance($balance->getBalance()+$amount);
		
		$trans->setTimeStart(new \DateTime("now"));
		$trans->setTimeEnd(new \DateTime("now"));
		$this->em->persist($balance);
		$this->em->persist($trans);
		$this->em->flush();
		
		$trans->setTimeEnd(new \DateTime("now"));
		$this->em->persist($trans);
		$this->em->flush();
		
		return true;
	}
}

?>