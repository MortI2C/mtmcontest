<?php

namespace IBM\MTMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IBM\MTMBundle\Services\CustomerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use IBM\MTMBundle\Form\CustomerType;
use IBM\MTMBundle\Entity\Customer;

class CustomerController extends Controller
{
    public function setStatusAction($account)
    {
    	$customerService = $this->get('ibmmtm.customerservice');
    	$status = $customerService->setCustomerStatus($account);
    	
    	$this->get('session')->getFlashBag()->add('success','The account has been '.$status);
    	return $this->redirect($this->generateUrl('customer'));
    }
    
    public function indexAction(Request $request)
    {
    	$query = $this->getDoctrine()->getManager()
    		->getRepository('IBMMTMBundle:Customer')
    		->createQueryBuilder('c');
    	

    	$filtreField = $request->query->get('filterField');
    	$filtreValue = $request->query->get('filterValue');
    	if($filtreField && $filtreValue)
    		$query = $query->where($filtreField." LIKE '%".$filtreValue."%'");
    	
    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    			$query,
    			$this->get('request')->query->get('page', 1)/*page number*/,
    			10/*limit per page*/
    	);
    	 
    	return $this->render('IBMMTMBundle:Customer:index.html.twig', array('pagination' => $pagination,
    				'filtres' => array('c.account' => 'Account',
    					'c.status' => 'Status',
    					'c.firstName' => 'First name',
    					'c.lastName' => 'Last name',
    					'c.city' => 'City',
    					'c.address' => 'Address',
    					'c.state' => 'State')));
    }
    
    public function newAction(Request $request)
    {
    	$form = $this->createForm('customer_type', new Customer(), array('action' => $this->generateUrl('customer_create')));
    	return $this->render('IBMMTMBundle:Customer:new.html.twig', array('form' => $form->createView()));
    }
    
    public function createAction(Request $request)
    {
	    	$customerService = $this->get('ibmmtm.customerservice');
	    	return $customerService->createCustomer($request, $this->container->get('security.encoder_factory'));
    }
    
    public function editAction(Request $request, $account)
    {
    	$customerService = $this->get('ibmmtm.customerservice');
    	return $customerService->editCustomer($request, $account);
    }
    
    public function deleteAction(Request $request, $account)
    {
    	$customerService = $this->get('ibmmtm.customerservice');
    	return $customerService->deleteCustomer($request, $account);
    }
}
