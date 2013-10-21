<?php

namespace Eps\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Eps\StaticPagesBundle\Entity\StaticPage;

class StaticController extends Controller
{
    
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
		$pages = $em->getRepository('EpsStaticPagesBundle:StaticPage')->findAll();
        return $this->render('EpsAdminBundle:Static:index.html.twig', array('pages' => $pages));
    }

    public function createAction()
    {
    	if ($this->getRequest()->getMethod() == 'POST') {
    		if($this->getRequest()->get('title') != NULL) {
    			$page = new StaticPage();
    			$page->setTitle($this->getRequest()->get('title'));

    			$em = $this->getDoctrine()->getManager();
            	$em->persist($page);
            	$em->flush();
    		}
    	} 

    	return $this->redirect($this->generateUrl('admin_static'));
    }

    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
		if($page == NULL) return $this->redirect($this->generateUrl('admin_static'));


    	if ($this->getRequest()->getMethod() == 'POST') {
    		if($this->getRequest()->get('title') != NULL) {
    			$page->setTitle($this->getRequest()->get('title'));
    			$page->setContent($this->getRequest()->get('content'));
            	$em->flush();
    		}
    		return $this->redirect($this->generateUrl('admin_static'));
    	} 

    	return $this->render('EpsAdminBundle:Static:edit.html.twig', array('page' => $page, "id" => $id));
    	
    }

    public function deleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
		
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
		if($page != NULL) {
			$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
			$em->remove($page);
			$em->flush();
		}

    	return $this->redirect($this->generateUrl('admin_static'));
    	
    }
}
