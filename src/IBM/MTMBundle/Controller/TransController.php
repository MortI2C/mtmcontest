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
class TransController extends Controller
{

    /**
     * Lists all Users entities.
     *
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()->getManager()
     	   ->getRepository('IBMMTMBundle:Trans')
      	  ->createQueryBuilder('t');
         
        
        $filtreField = $request->query->get('filterField');
        $filtreValue = $request->query->get('filterValue');
        if($filtreField && $filtreValue) {
        	if($filtreField == 't.type') {
        		$filtreValue =( $filtreValue == 'Deposit') ? 'D' : 'W';
        	}
        	$query = $query->where($filtreField." LIKE '%".$filtreValue."%'");
        }
         
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        		$query,
        		$this->get('request')->query->get('page', 1)/*page number*/,
        		10/*limit per page*/
        );
        
        return $this->render('IBMMTMBundle:Trans:index.html.twig', array('pagination' => $pagination,
        		'filtres' => array('t.account' => 'Account',
        				't.type' => 'Type',
        				't.amount' => 'Amount')));
    }
}
