<?php

namespace Eps\WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use JMS\Serializer\SerializationContext;

use Eps\PhotoBundle\Entity\Album;
use Eps\WebServiceBundle\Entity\HomeResponse;


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
        //$jsonEncode = json_encode(array('albums' => $reports));
        return new Response($reports);
    }
}
