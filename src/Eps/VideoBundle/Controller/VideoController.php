<?php

namespace Eps\VideoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eps\VideoBundle\Entity\Video;
use Eps\VideoBundle\Form\VideoType;

/**
 * Video controller.
 *
 */
class VideoController extends Controller
{

    /**
     * Lists all Video entities.
     *
     * @Route("/videos", name="videos")
     * @Method("GET")
     * @Template("EpsVideoBundle:Video:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EpsVideoBundle:Video')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Video entity.
     *
     * @Route("/video/{id}", name="video_show")
     * @Method("GET")
     * @Template("EpsVideoBundle:Video:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EpsVideoBundle:Video')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Video entity.');
        }

        return array(
            'entity'      => $entity
        );
    }
}
