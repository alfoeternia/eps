<?php

namespace Eps\MajBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('EpsMajBundle:Default:index.html.twig', array('name' => $name));
    }
}
