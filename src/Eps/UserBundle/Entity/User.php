<?php

namespace Eps\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Eps\UserBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eps\UserBundle\Entity\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @var integer $efreiUID
     *
     * @ORM\Column(name="efreiUID", type="integer")
     */
    private $efreiUID;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string $pseudo
     *
     * @ORM\Column(name="pseudo", type="string", length=255, nullable=true)
     */
    private $pseudo;

    /**
     * @var string $promo
     *
     * @ORM\Column(name="promo", type="string", length=4, nullable=true)
     */
    private $promo;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string $landline
     *
     * @ORM\Column(name="landline", type="string", length=255, nullable=true)
     */
    private $landline;

    /**
     * @var string $mobile
     *
     * @ORM\Column(name="mobile", type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @var datetime $lastlogin
     *
     * @ORM\Column(name="lastlogin", type="datetime", nullable=true)
     */
    private $lastlogin;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var string $roles
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

     /**
     * @var string $rank_id
     *
     * @ORM\ManyToOne(targetEntity="Rank")
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id")
     */
    private $rank;

	public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
		$this->setIsActive(true);
		$this->setPromo('0000');
        $this->addRole('ROLE_USER');
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
     * Set efreiUID
     *
     * @param integer $efreiUID
     */
    public function setEfreiUID($efreiUID)
    {
        $this->efreiUID = $efreiUID;
    }

    /**
     * Get efreiUID
     *
     * @return integer 
     */
    public function getEfreiUID()
    {
        return $this->efreiUID;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set lastlogin
     *
     * @param datetime $lastlogin
     */
    public function setLastlogin($lastlogin)
    {
        $this->lastlogin = $lastlogin;
    }

    /**
     * Get lastlogin
     *
     * @return datetime 
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set roles
     *
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Add a role
     *
     * @param array $roles
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
	
	/**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
	
	/**
     * @inheritDoc
     */
    public function equals(UserInterface $user)
    {
        return $this->username === $user->getUsername();
    }
	
	public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Set rank
     *
     * @param Eps\UserBundle\Entity\Rank $rank
     */
    public function setRank(\Eps\UserBundle\Entity\Rank $rank)
    {
        $this->rank = $rank;
    }

    /**
     * Get rank
     *
     * @return Eps\UserBundle\Entity\Rank 
     */
    public function getRank()
    {
        return $this->rank;
    }

    public function serialize()
    {
       return serialize($this->username);
    }
    
    public function unserialize($data)
    {
        $this->username = unserialize($data);
    }

}