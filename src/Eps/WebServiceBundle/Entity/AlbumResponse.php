<?php

namespace Eps\WebServiceBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;


/**
 * AlbumResponse
 *
 *
 * @ExclusionPolicy("all")
 */
class AlbumResponse
{

    /**
     * @Expose
     * @Groups({"detail"})
     */
    private $album;

    /**
     * Set albums
     *
     * @param array $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }
    /**
     * Get album
     *
     * @return EPS\PhotoBundle\Album
     */
    public function getAlbum()
    {
        return $this->album;
    }
}