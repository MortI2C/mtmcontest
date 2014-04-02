<?php

namespace IBM\MTMBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use IBM\MTMBundle\Entity\Users;
use IBM\MTMBundle\Form\UsersType;

/**
 * Users controller.
 *
 */
class UsersController extends Controller
{

    /**
     * Lists all Users entities.
     *
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getManager()
        ->getRepository('IBMMTMBundle:Users')
        ->createQueryBuilder('u');
         
        
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
        
        return $this->render('IBMMTMBundle:Users:index.html.twig', array('pagination' => $pagination,
        		'filtres' => array('u.username' => 'Username',
        				'u.email' => 'E-mail',
        				'u.role' => 'Role')));
    }
    
//     public function newAction(Request $request)
//     {
//     	$form = $this->createForm('users_type', new Users(), array('action' => $this->generateUrl('users_create')));
//     	return $this->render('IBMMTMBundle:Users:new.html.twig', array('form' => $form->createView()));
//     }
    
    public function createAction(Request $request)
    {
	    	$customerService = $this->get('ibmmtm.usersservice');
	    	return $customerService->createUser($request, $this->container->get('security.encoder_factory'));
    }
    
    public function editAction(Request $request, $id)
    {
    	$customerService = $this->get('ibmmtm.usersservice');
    	return $customerService->editUser($request, $id, $this->container->get('security.encoder_factory'));
    }
    
    public function deleteAction(Request $request, $id)
    {
    	$customerService = $this->get('ibmmtm.usersservice');
    	return $customerService->deleteUser($request, $id);
    }
}
