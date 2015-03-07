<?php

namespace Eps\StaticPagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eps\StaticPagesBundle\Entity\StaticPage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eps\StaticPagesBundle\Entity\SliderPhotoRepository")
 */
class SliderPhoto
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Eps\PhotoBundle\Entity\Album")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id")
     */
    private $album;
	
	/**
     * @ORM\ManyToOne(targetEntity="Eps\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string $photo
     *
     * @ORM\Column(name="photo", type="string", length=255)
     */
    private $photo;


	/**
     * @var boolean $actif
     *
     * @ORM\Column(name="actif", type="boolean", length=1)
     */
    private $actif;
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }	
	
    /**
     * Set album
     *
     * @param Eps\PhotoBundle\Entity\album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * Get album
     *
     * @return Eps\PhotoBundle\Entity\album 
     */
    public function getAlbum()
    {
        return $this->album;
    }
	
	/**
     * Set user
     *
     * @param Eps\UserBundle\Entity\user $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Eps\UserBundle\Entity\user 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set photo
     *
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * Get photo
     *
     * @return string 
     */
    public function getPhoto()
    {
        return $this->photo;
    }
	
	/**
     * Set actif
     *
     * @param boolen $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    /**
     * Get actif
     *
     * @return boolen 
     */
    public function getActif()
    {
        return $this->actif;
    }
}