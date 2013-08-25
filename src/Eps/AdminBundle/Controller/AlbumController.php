<?php

namespace Eps\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Eps\PhotoBundle\Entity\Album;


class AlbumController extends Controller
{
    
    public function indexAction($page = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->getRepository('EpsPhotoBundle:Album')
                    ->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->join('a.category', 'c')
                    ->join('a.reporters', 'r')
                    ->addSelect('c')
                    ->addSelect('r')
                    ->getQuery();
        $albums = $query->getResult();

        $adapter = new ArrayAdapter($albums);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);

        if( !$page ) $page = 1;

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('EpsAdminBundle:Album:index.html.twig', array( 'albums' => $albums,
                                                                            'pagerfanta' => $pagerfanta));
    }

    /*public function createAction()
    {
    	if ($this->getRequest()->getMethod() == 'POST') {
    		if($this->getRequest()->get('title') != NULL) {
    			$page = new StaticPage();
    			$page->setTitle($this->getRequest()->get('title'));

    			$em = $this->getDoctrine()->getEntityManager();
            	$em->persist($page);
            	$em->flush();
    		}
    	} 

    	return $this->redirect($this->generateUrl('admin_static'));
    }

    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
		
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
    	$em = $this->getDoctrine()->getEntityManager();
		
		$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
		if($page != NULL) {
			$page = $em->getRepository('EpsStaticPagesBundle:StaticPage')->find($id);
			$em->remove($page);
			$em->flush();
		}

    	return $this->redirect($this->generateUrl('admin_static'));
    	
    }*/
}
