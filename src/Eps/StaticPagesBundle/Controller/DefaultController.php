<?php

namespace Eps\StaticPagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);

		if($page == NULL) {
			$page['content'] = "Cette page n'existe pas.";
		}

        return $this->render('EpsStaticPagesBundle:Default:index.html.twig', array('page' => $page));
    }
}
