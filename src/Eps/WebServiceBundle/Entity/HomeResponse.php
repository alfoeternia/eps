<?php

namespace Eps\WebServiceBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\MaxDepth;


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
     * @MaxDepth(4)
     * @Groups({"list"})
     */
    private $albums;
     * @Groups({"list"})

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