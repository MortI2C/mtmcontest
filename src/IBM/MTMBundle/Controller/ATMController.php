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
class ATMController extends Controller
{

    /**
     * Lists all Users entities.
     *
     */
    public function indexAction(Request $request)
    {
       $atmService = $this->get('ibmmtm.atmservice');
       return $atmService->index($request);
    }
    
    public function transactionAction(Request $request)
    {
    	$atmService = $this->get('ibmmtm.atmservice');
    	return $atmService->doTransaction($request);
    }
}
