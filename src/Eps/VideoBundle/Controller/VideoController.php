<?php

namespace Eps\VideoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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

		
		return $this->render('EpsVideoBundle:View:index.html.twig', 
			array(	'entity' => $video,
				));
				
    }

    /**
     * Find and donwload a Video entity.
     *
     * @Route("/video/download/{id}", name="video_download")
     * @Method("GET")
     */
    public function downloadAction($id)
    {
	
		$em = $this->getDoctrine()->getManager();
		
		$video = $em->getRepository('EpsVideoBundle:Video')->find($id);

		if(	($video->getAccess() == "ROLE_USER" && !$this->get('security.context')->isGranted('ROLE_USER')) ||
			($video->getAccess() == "ROLE_REPORTER" && !$this->get('security.context')->isGranted('ROLE_REPORTER')))
			return $this->render('EpsVideoBundle:View:forbidden.html.twig');

		
		$file = $this->get('kernel')->getRootDir(). '/../www/data/' .$video->getYear(). '/' .$video->getUrl();

		if(file_exists($file) == false) 
		{
			return $this->render('EpsVideoBundle:View:notfound.html.twig');
		}
		
		$session = $this->getRequest()->getSession();
		if(!$session->get('video_'.$id)) {
			$video->setDownloadCount($video->getDownloadCount()+1);
			$em->flush();
			$session->set('video_'.$id, true);
		}

		$response = new BinaryFileResponse($file);
		$response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
		
		return $response;
    }

}
