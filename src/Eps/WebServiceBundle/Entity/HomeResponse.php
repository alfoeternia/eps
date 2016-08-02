<?php

namespace Eps\WebServiceBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;


/**
 * HomeResponse
 *
 *
 * @ExclusionPolicy("all")
 */
class HomeResponse
{

    /**
     * @Expose
     * @Groups({"list"})
     */
    private $albums;

    /**
     * Set albums
     *
     * @param array $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }
    /**
     * Get albums
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAlbums()
    {
        return $this->albums;
    }
}