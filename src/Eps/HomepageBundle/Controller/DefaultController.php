<?php

namespace Eps\HomepageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Eps\StaticPagesBundle\Entity\SliderPhoto;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$query = $em->getRepository('EpsPhotoBundle:Album')
					->createQueryBuilder('a')
					->where('a.published = 1')
					->orderBy('a.id', 'DESC')
					->setMaxResults(10)
					->join('a.category', 'c')
					->join('a.reporters', 'r')
					->addSelect('c')
					->addSelect('r')
					->getQuery();
        $albums = $query->getResult();

        $query = $em->getRepository('EpsUserBundle:User')
					->createQueryBuilder('u')
					->orderBy('u.lastLogin', 'DESC')
					->where('u.lastLogin != \'0000-00-00 00:00:00\'')
					->setMaxResults(10)
					->getQuery();
        $users = $query->getResult();
		
		$query = $em->getRepository('EpsStaticPagesBundle:SliderPhoto')
					->createQueryBuilder('s')
					->orderBy('s.id', 'ASC')
					->where('s.actif = 1')
					->getQuery();
        $sliders = $query->getResult();

        return $this->render('EpsHomepageBundle:Default:index.html.twig', 
        	array(	'albums' => $albums,
        			'users' => $users,
        			'sliders' => $sliders
        			));
    }
}
