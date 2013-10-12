<?php
namespace Eps\PhotoBundle\EventListener;

use Oneup\UploaderBundle\Event\ValidationEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;

class AlbumIdValidationListener
{
    public function onValidate(ValidationEvent $event)
    {
        $request = $event->getRequest();
        $file    = $event->getFile();
        $album_id = intval($request->get('album_id'));
        $album_year = intval($request->get('album_year'));
        if(empty($album_id) || empty($album_year)) {
        	throw new ValidationException('Album ID and/or year is missing.');
        }

    }
}