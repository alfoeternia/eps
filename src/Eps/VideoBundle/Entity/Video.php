<?php

namespace Eps\VideoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eps\VideoBundle\Entity\VideoRepository")
 */
class Video
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=4)
     */
    private $year;

    /**
     * @var integer
     *
     * @ORM\Column(name="download_count", type="integer")
     */
    private $downloadCount;

    /**
     * @var string
     *
     * @ORM\Column(name="access", type="string", length=255)
     */
    private $access;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;
	
	/**
     * @var string
     *
     * @ORM\Column(name="thumb", type="string", length=255)
     */
    private $thumb;

    /**
     * @ORM\ManyToMany(targetEntity="Eps\UserBundle\Entity\User")
     */
    private $reporters;

     public function __construct()
    {
        $this->downloadCount = 0;
        $this->access = 'ROLE_REPORTER';
        $this->reporters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->year = date("Y");
		$this->source = 'LOCAL';
		$this->url = '';
        $this->thumb = '';
    }


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
     * @return Video
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set description
     *
     * @param string $description
     * @return Video
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set year
     *
     * @param string $year
     * @return Video
     */
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    /**
     * Get year
     *
     * @return string 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set downloadCount
     *
     * @param integer $downloadCount
     * @return Video
     */
    public function setDownloadCount($downloadCount)
    {
        $this->downloadCount = $downloadCount;
    
        return $this;
    }

    /**
     * Get downloadCount
     *
     * @return integer 
     */
    public function getDownloadCount()
    {
        return $this->downloadCount;
    }

    /**
     * Set access
     *
     * @param string $access
     * @return Video
     */
    public function setAccess($access)
    {
        $this->access = $access;
    
        return $this;
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
     * Set url
     *
     * @param string $url
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Video
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }
	
	/**
     * Set thumb
     *
     * @param string $thumb
     * @return Video
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    
        return $this;
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

    public function __toString()
    {
        return '('.$this->id.') '.$this->name;
    }
}
