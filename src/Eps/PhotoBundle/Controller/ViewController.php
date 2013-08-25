<?php

namespace Eps\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ViewController extends Controller
{
    
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
		
		$album = $em->getRepository('EpsPhotoBundle:Album')->find($id);

		if(	($album->getAccess() == "ROLE_USER" && !$this->get('security.context')->isGranted('ROLE_USER')) ||
			($album->getAccess() == "ROLE_REPORTER" && !$this->get('security.context')->isGranted('ROLE_REPORTER'))
		  )
			return $this->render('EpsPhotoBundle:View:forbidden.html.twig');

		$path = $this->get('kernel')->getRootDir() . '/../web/miniatures/' . $id;
		$images = glob($path . "/*.jpg");
		$images = array_map('basename', $images);
		
		return $this->render('EpsPhotoBundle:View:index.html.twig', 
			array(	'album' => $album,
					'images'=> $images
				));
    }
}

