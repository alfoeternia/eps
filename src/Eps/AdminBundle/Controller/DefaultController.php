<?php

namespace Eps\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('EpsAdminBundle:Default:index.html.twig');
    }
}
