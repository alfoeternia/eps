<?php

namespace Eps\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ListController extends Controller
{
    
    public function indexAction()
    {  

        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->getRepository('EpsUserBundle:User')
                    ->createQueryBuilder('u')
                    ->join('u.rank', 'r')
                    ->orderBy('r.id', 'ASC')
                    ->getQuery();
        $members = $query->getResult();

        return $this->render('EpsUserBundle:List:index.html.twig', array('members' => $members));
    }

}
