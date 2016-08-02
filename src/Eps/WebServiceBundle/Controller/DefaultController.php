<?php

namespace Eps\WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use JMS\Serializer\SerializationContext;

use Eps\PhotoBundle\Entity\Album;
use Eps\WebServiceBundle\Entity\HomeResponse;
use Eps\StaticPagesBundle\Entity\SliderPhoto;
use Eps\WebServiceBundle\Entity\SliderResponse;


class DefaultController extends Controller
{

    public function homeAction()
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

        $entity = new HomeResponse();
        $entity->setAlbums($albums);


        $serializer = $this->container->get('jms_serializer');
        $reports = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('list')));


        //Just convert array to JSON and return result
        $response = new Response($reports);
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        return $response;
    }

    public function sliderAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EpsStaticPagesBundle:SliderPhoto')
                    ->createQueryBuilder('s')
                    ->where('s.actif = 1')
                    ->orderBy('s.id', 'ASC')
                    ->join('s.album', 'a')
                    ->join('s.user', 'u')
                    ->addSelect('a')
                    ->addSelect('u')
                    ->getQuery();
        $sliders = $query->getResult();

        $entity = new SliderResponse();
        $entity->setSliders($sliders);


        $serializer = $this->container->get('jms_serializer');
        $reports = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('list')));


        //Just convert array to JSON and return result
        $response = new Response($reports);
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        return $response;
    }
}
