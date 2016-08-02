<?php

namespace Eps\WebServiceBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;


/**
 * AlbumsResponse
 *
 *
 * @ExclusionPolicy("all")
 */
class AlbumsResponse
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

    /**
     * @Expose
     * @Groups({"list"})
     */
    private $pageNumber;

    /**
     * Set pageNumber
     *
     * @param array $pageNumber
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = $pageNumber;
    }
    /**
     * Get pageNumber
     *
     * @return integer
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }
}