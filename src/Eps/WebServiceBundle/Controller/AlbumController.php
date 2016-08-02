<?php

namespace Eps\WebServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use JMS\Serializer\SerializationContext;
use Eps\WebServiceBundle\Entity\AlbumsResponse;

use Eps\PhotoBundle\Entity\Album;


class AlbumController extends Controller
{

    public function getAlbumsAction($pageNumber = null)
    {
        if ($pageNumber != null && $pageNumber != 0) {
            $firstResulst = $pageNumber * 20 + 1;
        }
        else {
            $firstResulst = 0;
            $pageNumber = 0;
        }
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('EpsPhotoBundle:Album')
                    ->createQueryBuilder('a')
                    ->where('a.published = 1')
                    ->orderBy('a.id', 'DESC')
                    ->setMaxResults(20)
                    ->setFirstResult($firstResulst)
                    ->join('a.category', 'c')
                    ->join('a.reporters', 'r')
                    ->addSelect('c')
                    ->addSelect('r')
                    ->getQuery();
        $albums = $query->getResult();

        $entity = new AlbumsResponse();
        $entity->setAlbums($albums);
        $entity->setPageNumber($pageNumber);


        $serializer = $this->container->get('jms_serializer');
        $reports = $serializer->serialize($entity, 'json', SerializationContext::create()->setGroups(array('list')));


        //Just convert array to JSON and return result
        $response = new Response($reports);
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        return $response;
    }

    
}
