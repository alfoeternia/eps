<?php
namespace Eps\AdminBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Eps\VideoBundle\Entity\Video;
use Eps\StaticPagesBundle\Entity\SliderPhoto;

class UploadListener
{
    private $container;

    public function __construct($doctrine, ContainerInterface $container)
    {
        $this->doctrine = $doctrine;
        $this->container = $container;
    }

    public function onUpload(PostPersistEvent $event)
    {
        // Variables from event
        $request = $event->getRequest();
		
		
        // Variables from request
        $album_id = $request->get('album_id');
        $album_year = $request->get('album_year');
		
		if(isset($album_id) && isset($album_year)) 
		{
			$file = $event->getFile();

			// Folder variables
			$root_dir = $this->container->get('kernel')->getRootDir() . '/../www/';
			$originals_dir = $root_dir.'originals/'.$album_year.'/'.$album_id;
			$data_dir = $root_dir.'data/'.$album_year.'/'.$album_id;
			$miniatures_dir = $root_dir.'miniatures/'.$album_id;

			// Create folders if they does not exists
			if(!is_dir($originals_dir)) mkdir($originals_dir, 0777, true);
			if(!is_dir($data_dir)) mkdir($data_dir, 0777, true);
			if(!is_dir($miniatures_dir)) mkdir($miniatures_dir, 0777, true);

			// Move the file to originals dir
			$filename = $file->getBasename();
			$file->move($originals_dir);

			// images file path
			$original_img = $originals_dir.'/'.$filename;
			$watermark_img = $root_dir.'watermark.png';

			// Create the thumbnail
			$thumb = new \Imagick($original_img);
			$thumb->resizeImage(0, 200, \Imagick::FILTER_LANCZOS, 1);
			$thumb->writeImage($miniatures_dir.'/'.$filename);
			$thumb->destroy(); 

			// Create the image displayed on website with watermark
			$image = new \Imagick($original_img);
			$watermark = new \Imagick($watermark_img);
			$image->resizeImage(2048, 2048, \Imagick::FILTER_LANCZOS, 1, true);
			$position = array(
				'x' => $image->getImageWidth() - $watermark->getImageWidth() - 5,
				'y' => $image->getImageHeight() - $watermark->getImageHeight() - 5);
			$image->compositeImage($watermark, $watermark->getImageCompose(), $position['x'], $position['y'] );
			$image->writeImage($data_dir.'/'.$filename);
			$image->destroy();
		}
		else
		{
			
			// Variables from request
			$video_id = $request->get('video_id');
			$video_year = $request->get('video_year');
			if(isset($video_id) && isset($video_year)) 
			{
				// Folder variables
				$root_dir = $this->container->get('kernel')->getRootDir() . '/../www/';
				$data_dir = $root_dir.'data/'.$video_year.'/';

				if(!is_dir($data_dir)) mkdir($data_dir, 0777, true);
				
					
				$file = $event->getFile();

				// Move the file to originals dir
				$filename = $file->getBasename();
				$file->move($data_dir);
				
				//On met a jour la vidéo correspondante
				
				
				$em = $this->doctrine->getManager();
				$entity = $em->getRepository('EpsVideoBundle:Video')->find($video_id);

				if (!$entity) {
					throw $this->createNotFoundException('Unable to find Video entity.');
				}
				$entity->setUrl($filename);
				$em->persist($entity);
				$em->flush();

			}
			else 
			{
				
				$video_thumb_id = $request->get('video_thumb_id');
				if(isset($video_thumb_id)) 
				{
					// Folder variables
					$root_dir = $this->container->get('kernel')->getRootDir() . '/../www/';
					$originals_dir = $root_dir.'miniaturesVideo/'.$video_thumb_id;
					$originals_dir_miniature = $root_dir.'miniaturesVideo/'.$video_thumb_id.'/miniature';

					if(!is_dir($originals_dir_miniature)) mkdir($originals_dir_miniature, 0777, true);
					
						
					$file = $event->getFile();
					
					
					
					
					
					
					
					// Move the file to originals dir
					$filename = $file->getBasename();
					$file->move($originals_dir);

					// images file path
					$original_img = $originals_dir.'/'.$filename;

					// Create the thumbnail
					$thumb = new \Imagick($original_img);
					$thumb->resizeImage(0, 120, \Imagick::FILTER_LANCZOS, 1);
					$thumb->writeImage($originals_dir_miniature.'/'.$filename);
					$thumb->destroy(); 
					
					//On met a jour la vidéo correspondante
					
					
					$em = $this->doctrine->getManager();
					$entity = $em->getRepository('EpsVideoBundle:Video')->find($video_thumb_id);

					if (!$entity) {
						throw $this->createNotFoundException('Unable to find Video entity.');
					}
					$entity->setThumb($filename);
					$em->persist($entity);
					$em->flush();

				}
				else 
				{

					$sliderPhoto_id = $request->get('sliderPhoto_id');
					if(isset($sliderPhoto_id)) 
					{
			
						$file = $event->getFile();
						
						// Move the file to originals dir
						$filename = $file->getBasename();
						
						$em = $this->doctrine->getManager();
						$entity = $em->getRepository('EpsStaticPagesBundle:SliderPhoto')->find($sliderPhoto_id);

						if (!$entity) {
							throw $this->createNotFoundException('Unable to find Photo entity.');
						}
						$entity->setPhoto($filename);
						$em->persist($entity);
						$em->flush();
						
									// Folder variables
						$root_dir = $this->container->get('kernel')->getRootDir() . '/../www/img/slider';
						
						$file->move($root_dir);				
						

					}
				
				}
			}
			
		}
        

        
        // Done ;-)

    }
}
