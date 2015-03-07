<?php

namespace Eps\VideoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;


class DefaultController extends Controller
{
    
    public function indexAction($year = 'all')
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('EpsVideoBundle:Video')->findAllByYear($year);
		$years = $em->getRepository('EpsVideoBundle:Video')->findYears();

        $adapter = new ArrayAdapter($videos);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(15);

		$page = $this->get('request')->query->get('page',1);
        try {
            $pagerfanta->setCurrentPage($page);
        } catch (OutOfRangeCurrentPageException $e) {
            throw new NotFoundHttpException();
        }
		
		return $this->render('EpsVideoBundle:Default:index.html.twig', 
							array(	'videos'	 	=> $videos,
									'pagerfanta' 	=> $pagerfanta,
									'years'		 	=> $years,
									'currentyear'	=> $year,
								)
							);
    }
	
	    /**
     * Lists all Video entities.
     *
     * @Route("/videos", name="videos")
     * @Method("GET")
     * @Template("EpsVideoBundle:Video:index.html.twig")
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EpsVideoBundle:Video')->findAll();

        return array(
            'entities' => $entities,
        );
    }
     */
}
