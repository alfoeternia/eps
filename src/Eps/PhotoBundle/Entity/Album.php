<?php

namespace Eps\PhotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eps\PhotoBundle\Entity\Album
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eps\PhotoBundle\Entity\AlbumRepository")
 */
class Album
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="Eps\UserBundle\Entity\User")
     */
    private $reporters;

    /**
     * @var string $thumb
     *
     * @ORM\Column(name="thumb", type="string", length=255)
     */
    private $thumb;

    /**
     * @ORM\ManyToOne(targetEntity="Eps\VideoBundle\Entity\Video")
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id")
     */
    private $video;

    /**
     * @var boolean $published
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var string $access
     *
     * @ORM\Column(name="access", type="string", length=255)
     */
    private $access;

    /**
     * @var integer $visit_count
     *
     * @ORM\Column(name="visit_count", type="integer")
     */
    private $visit_count;

    /**
     * @var integer $like_count
     *
     * @ORM\Column(name="like_count", type="integer")
     */
    private $like_count;


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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set thumb
     *
     * @param string $thumb
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    }

    /**
     * Get thumb
     *
     * @return string 
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set video
     *
     * @param Eps\VideoBundle\Entity\Video $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * Get video
     *
     * @return Eps\VideoBundle\Entity\Video 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set access
     *
     * @param string $access
     */
    public function setAccess($access)
    {
        $this->access = $access;
    }

    /**
     * Get access
     *
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set visit_count
     *
     * @param integer $visitCount
     */
    public function setVisitCount($visitCount)
    {
        $this->visit_count = $visitCount;
    }

    /**
     * Get visit_count
     *
     * @return integer 
     */
    public function getVisitCount()
    {
        return $this->visit_count;
    }

    /**
     * Set like_count
     *
     * @param integer $likeCount
     */
    public function setLikeCount($likeCount)
    {
        $this->like_count = $likeCount;
    }

    /**
     * Get like_count
     *
     * @return integer 
     */
    public function getLikeCount()
    {
        return $this->like_count;
    }

    /**
     * Set reporters
     *
     * @param array $reporters
     */
    public function setReporters($reporters)
    {
        $this->reporters = $reporters;
    }
    
    /**
     * Add reporter
     *
     * @param Eps\UserBundle\Entity\User $reporters
     */
    public function addReporter($reporter)
    {
        $this->reporters[] = $reporter;
    }

    /**
     * Get reporters
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReporters()
    {
        return $this->reporters;
    }

    /**
     * Set category
     *
     * @param Eps\PhotoBundle\Entity\category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Eps\PhotoBundle\Entity\category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __construct()
    {
        $this->thumb = '../no_thumb.png';
        $this->published = false;
        $this->reporters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visit_count = 0;
        $this->like_count = 0;
    }
    

    /**
     * Add reporters
     *
     * @param Eps\UserBundle\Entity\User $reporters
     */
    public function addUser(\Eps\UserBundle\Entity\User $reporters)
    {
        $this->reporters[] = $reporters;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Album
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Remove reporters
     *
     * @param \Eps\UserBundle\Entity\User $reporters
     */
    public function removeReporter(\Eps\UserBundle\Entity\User $reporters)
    {
        $this->reporters->removeElement($reporters);
    }
	
	public function __toString()
    {
        return $this->id.' - '.$this->name;
    }
}