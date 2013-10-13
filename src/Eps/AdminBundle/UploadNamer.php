<?php

namespace Eps\AdminBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Oneup\UploaderBundle\Uploader\Response\ResponseInterface;

class UploadNamer implements NamerInterface
{


    public function name(UploadedFile $file)
    {
    	$filename = basename($file->getClientOriginalName());
    	//$filename = 'image_'.rand(1, 99).'.jpg';
        return $filename;
    }
}