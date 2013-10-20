<?php

namespace Eps\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ListController extends Controller
{
    
    public function indexAction()
    {  

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EpsUserBundle:User')
                    ->createQueryBuilder('u')
                    //->join('u.rank', 'r')
                    ->orderBy('u.lastname', 'ASC')
                    ->getQuery();
        $members = $query->getResult();

        return $this->render('EpsUserBundle:List:index.html.twig', array('members' => $members));
    }

    public function showAction($id)
    {  

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EpsUserBundle:User')
                    ->findOneById($id);


        $query = $em->getRepository('EpsPhotoBundle:Album')
                    ->createQueryBuilder('a')
                    ->join('a.category', 'c')
                    ->join('a.reporters', 'r')
                    ->addSelect('c')
                    ->addSelect('r')
                    ->where('r = :reporter')
                    ->orderBy('a.date', 'DESC')
                    ->getQuery();
        $query->setParameters(array('reporter' => $user));
        $albums = $query->getResult();

        return $this->render('EpsUserBundle:List:show.html.twig', 
                    array(  'user' => $user,
                            'albums' => $albums
                        ));
    }

}
