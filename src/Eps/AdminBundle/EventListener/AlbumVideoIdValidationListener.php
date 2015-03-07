<?php
namespace Eps\AdminBundle\EventListener;

use Oneup\UploaderBundle\Event\ValidationEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;

class AlbumVideoIdValidationListener
{
    public function onValidate(ValidationEvent $event)
    {
        $request = $event->getRequest();
        $file    = $event->getFile();

        $album_id = intval($request->get('album_id'));
        $album_year = intval($request->get('album_year'));
        $video_id = intval($request->get('video_id'));
        $video_year = intval($request->get('video_year'));
        $video_thumb_id = intval($request->get('video_thumb_id'));
        $sliderPhoto_id = intval($request->get('sliderPhoto_id'));
        
        if((empty($album_id) || empty($album_year)) && (empty($video_id) || empty($video_year)) && empty($video_thumb_id) && empty($sliderPhoto_id))
        {
			throw new ValidationException('Album Video ID and/or year is missing.');
        }

    }
}