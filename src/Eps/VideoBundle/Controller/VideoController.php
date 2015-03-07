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
     * Finds and displays a Video entity.
     *
     * @Route("/video/{id}", name="video_show")
     * @Method("GET")
     * @Template("EpsVideoBundle:Video:show.html.twig")
     */
    public function indexAction($id)
    {
	
	$em = $this->getDoctrine()->getManager();
		
		$video = $em->getRepository('EpsVideoBundle:Video')->find($id);

		if(	($video->getAccess() == "ROLE_USER" && !$this->get('security.context')->isGranted('ROLE_USER')) ||
			($video->getAccess() == "ROLE_REPORTER" && !$this->get('security.context')->isGranted('ROLE_REPORTER')))
			return $this->render('EpsVideoBundle:View:forbidden.html.twig');


		$session = $this->getRequest()->getSession();
		if(!$session->get('video_'.$id)) {
			$video->setDownloadCount($video->getDownloadCount()+1);
			$em->flush();
			$session->set('video_'.$id, true);
		}

		
		return $this->render('EpsVideoBundle:View:index.html.twig', 
			array(	'entity' => $video,
				));
				
    }
}
