<?php
namespace Eps\AdminBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
        $file = $event->getFile();

        // Variables from request
        $album_id = $request->get('album_id');
        $album_year = $request->get('album_year');

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

        
        // Done ;-)

    }
}
