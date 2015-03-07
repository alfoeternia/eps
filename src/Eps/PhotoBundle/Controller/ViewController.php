<?php

namespace Eps\PhotoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use \ZipArchive;

class ViewController extends Controller
{
    
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
		
		$album = $em->getRepository('EpsPhotoBundle:Album')->find($id);

		if(	($album->getAccess() == "ROLE_USER" && !$this->get('security.context')->isGranted('ROLE_USER')) ||
			($album->getAccess() == "ROLE_REPORTER" && !$this->get('security.context')->isGranted('ROLE_REPORTER')) ||
			(!$album->isPublished() && !$this->get('security.context')->isGranted('ROLE_REPORTER'))
		  )
			return $this->render('EpsPhotoBundle:View:forbidden.html.twig');


		$session = $this->getRequest()->getSession();
		if(!$session->get('album_'.$id)) {
			$album->setVisitCount($album->getVisitCount()+1);
			$em->flush();
			$session->set('album_'.$id, true);
		}


		$path = $this->get('kernel')->getRootDir() . '/../www/miniatures/' . $id;
		$images = glob("$path/*.{png,jpg,jpeg,gif,PNG,JPG,JPEG,GIF}",GLOB_BRACE);
		if(!empty($images))
		{
			$images = array_map('basename', $images);
		}
		
		return $this->render('EpsPhotoBundle:View:index.html.twig', 
			array(	'album' => $album,
					'images'=> $images
				));
    }
	
	public function downloadAction($id)
    {
				
		$em = $this->getDoctrine()->getManager();
		
		$album = $em->getRepository('EpsPhotoBundle:Album')->find($id);

		if(	($album->getAccess() == "ROLE_USER" && !$this->get('security.context')->isGranted('ROLE_USER')) ||
			($album->getAccess() == "ROLE_REPORTER" && !$this->get('security.context')->isGranted('ROLE_REPORTER')) ||
			(!$album->isPublished() && !$this->get('security.context')->isGranted('ROLE_REPORTER'))
		  )
			return $this->render('EpsPhotoBundle:View:forbidden.html.twig');

		$year = $album->getDate()->format("Y");
		//$session = $this->getRequest()->getSession();
		
		//if(!$session->get('album_'.$id)) {
		//	$album->setDownloadCount($album->getDownloadCount()+1);
		//	$em->flush();
		//	$session->set('album_'.$id, true);
		//}


		

		$file = $this->get('kernel')->getRootDir() . '/../web/DownloadedZip/' .$year. '-Album-' .$album->getName(). '.zip';
		if(file_exists($file) == false) 
		{
			$path = $this->get('kernel')->getRootDir() . '/../www/data/'. $year . '/' . $id;
			$images = glob("$path/*.{png,jpg,jpeg,gif,PNG,JPG,JPEG,GIF}",GLOB_BRACE);
			if(!empty($images))
			{
				$images = array_map('basename', $images);
			}
			$zip = new ZipArchive();
			// Zip will open and overwrite the file, rather than try to read it.
			$zip->open($file, ZipArchive::OVERWRITE);

			foreach ($images as $f) {
				$zip->addFile($path. "/" .basename($f), $f); 
			}
			$zip->close(); 
		}
		$response = new BinaryFileResponse($file);
		//$response->setContent(readfile($file));
		$response->headers->set('Content-Type', 'application/zip');
		$response->headers->set('Content-Disposition', 'attachment; filename="Album-' .$album->getName(). '-' .$year. '.zip"');
		$response->headers->set('Content-Length', filesize($file));
		
		//unlink($file);
		return $response;
			   
	}
}

