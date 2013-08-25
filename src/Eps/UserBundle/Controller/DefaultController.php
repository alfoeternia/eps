<?php

namespace Eps\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        
        return $this->render('EpsUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
