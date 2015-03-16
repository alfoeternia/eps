<?php

namespace Eps\StaticPagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);

		if($page == NULL) {
			$page['content'] = "Cette page n'existe pas.";
		}
		else if($page->getId() == 1 && $page->getActif() == false) {
		    $page->setContent("Aucun stream actuellement en cours.");
		}


        return $this->render('EpsStaticPagesBundle:Default:index.html.twig', array('page' => $page));
    }
}
