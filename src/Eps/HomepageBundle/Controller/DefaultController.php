<?php

namespace Eps\HomepageBundle\Controller;
//namespace Eps\PhotoBundle\Entity\Album;
//namespace Eps\UserBundle\Entity\Member;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
		$em = $this->getDoctrine()->getManager();
		$query = $em->getRepository('EpsPhotoBundle:Album')
					->createQueryBuilder('a')
					->orderBy('a.id', 'DESC')
					->setMaxResults(10)
					->join('a.category', 'c')
					->join('a.reporters', 'r')
					->addSelect('c')
					->addSelect('r')
					->getQuery();
        $albums = $query->getResult();

        return $this->render('EpsHomepageBundle:Default:index.html.twig', array('albums' => $albums));
    }
}
