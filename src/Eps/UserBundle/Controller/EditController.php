<?php

namespace Eps\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class EditController extends Controller
{
    
    public function indexAction()
    {  
        return $this->render('EpsUserBundle:Edit:index.html.twig');
    }

    public function editAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	$request = $this->getRequest();
    	$success = false;

    	if ($request->getMethod() == 'POST') {

    		$user->setPseudo($request->get('pseudo'));
    		$user->setPromo($request->get('promo'));

    		$em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            $success = true;
    	}

        return $this->render('EpsUserBundle:Edit:edit.html.twig', array('user' => $user, 'success' => $success));
    }
}
