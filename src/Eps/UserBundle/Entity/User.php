<?php

namespace Eps\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Eps\UserBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eps\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * Permet de récupérer l'username de l'utilisateur pour la serialization (grace aux annotations)
     *
     * @VirtualProperty
     * @SerializedName("username")
     * @Groups({"list", "detailAlbum"})
     */
    public function serializeUsername(){
        return $this->getUsername();
    }

    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Groups({"list", "detailAlbum"})
     */
    protected $id;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"list", "detailAlbum"})
     */
    protected $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"list", "detailAlbum"})
     */
    protected $lastname;

    /**
     * @var string $promo
     *
     * @ORM\Column(name="promo", type="string", length=4, nullable=true)
     * @Expose
     * @Groups({"list", "detailAlbum"})
     */
    protected $promo;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @var string $landline
     *
     * @ORM\Column(name="landline", type="string", length=255, nullable=true)
     */
    protected $landline;

    /**
     * @var string $mobile
     *
     * @ORM\Column(name="mobile", type="string", length=255, nullable=true)
     */
    protected $mobile;

    /**
     * @var string $rank
     *
     * @ORM\Column(name="rank", type="string", length=255, nullable=true)
     */
    protected $rank;

    /**
     * @var \DateTime $lastActivity
     *
     * @ORM\Column(name="last_activity", type="datetime")
     */
    private $lastActivity;

    /**
     * @Assert\File(maxSize="6000000")
     */
    protected $file;

    protected $temp;

	public function __construct()
    {
        parent::__construct();
		$this->setPromo('0000');
        $this->addRole('ROLE_USER');
        $this->setRank('USER');
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
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

     public function setRole($role)
    {
        $this->roles = array();
        if($role) {
            $this->addRole($role);
        }
        return $this;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Get pseudo
     *
     * @return string 
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set promo
     *
     * @param string $promo
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
    }

    /**
     * Get promo
     *
     * @return string 
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * Set landline
     *
     * @param string $landline
     */
    public function setLandline($landline)
    {
        $this->landline = $landline;
    }

    /**
     * Get landline
     *
     * @return string 
     */
    public function getLandline()
    {
        return $this->landline;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set rank
     *
     * @param string $mobile
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return string 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set lastActivity
     *
     * @param \DateTime $lastActivity
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = $lastActivity;
    }

    /**
     * Get lastActivity
     *
     * @return \DateTime 
     */
    public function getLastActivity()
    {
        return $this->lastActivity;
    }

    public function getLastActivityText()
    {
	return $this->lastActivity->format('Ymd His');
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
        }

        $this->upload();
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->temp);
            // clear the temp image path
            $this->temp = null;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->id.'.jpg'
        );

        $this->setFile(null);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }

    public function getProfilePicture()
    {
        if(is_file($this->getAbsolutePath()))
            return $this->getWebPath();
        else return 'img/default-user-icon-profile.png';
    }

    public function getAbsolutePath()
    {
        return $this->getUploadRootDir().'/'.$this->id.'.jpg';
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->id.'.jpg';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../www/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/user_profile_img';
    }

    public function __toString()
    {
        return $this->id.' - '.$this->username.' ('.$this->firstname.' '.$this->lastname.')';
    }
}
