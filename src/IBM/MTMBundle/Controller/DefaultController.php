<?php

namespace IBM\MTMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IBMMTMBundle:Default:index.html.twig');
    }
}
