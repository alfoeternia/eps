<?php

namespace Eps\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;


class DefaultController extends Controller
{
    
    public function indexAction($year = 'all', $cat = 'all')
    {
        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository('EpsPhotoBundle:Album')->findAllByYearAndCategoryC($year, $cat);
        $categories = $em->getRepository('EpsPhotoBundle:Category')->findAll();
		$years = $em->getRepository('EpsPhotoBundle:Album')->findYears();

        $adapter = new ArrayAdapter($albums);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);

		$page = $this->get('request')->query->get('page',1);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (OutOfRangeCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
		
		return $this->render('EpsPhotoBundle:Default:index.html.twig', 
							array(	'albums'	 	=> $albums,
									'pagerfanta' 	=> $pagerfanta,
									'categories' 	=> $categories,
									'years'		 	=> $years,
									'currentyear'	=> $year,
									'currentcat'	=> $cat,
								)
							);
    }
}
