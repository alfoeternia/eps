<?php

namespace Eps\ReporterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('EpsReporterBundle:Default:index.html.twig');
    }

    public function albumsViewAction($page = null)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EpsPhotoBundle:Album')
                    ->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->join('a.category', 'c')
                    ->join('a.reporters', 'r')
                    ->addSelect('c')
                    ->addSelect('r')
                    ->where('r = :reporter')
                    ->getQuery();
        $query->setParameters(array('reporter' => $this->get('security.context')->getToken()->getUser()));
        $albums = $query->getResult();

        $adapter = new ArrayAdapter($albums);

        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(10);

        if( !$page ) $page = 1;

        try {
            $pagerfanta->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            throw new NotFoundHttpException();
        }

        return $this->render('EpsReporterBundle:Default:albums.html.twig', array( 'albums' => $albums,
                                                                            'pagerfanta' => $pagerfanta));
    }
}
