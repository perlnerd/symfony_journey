<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserAuth
 *
 * @ORM\Table("user_auth")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserAuthRepository")
 */
class UserAuth implements AdvancedUserInterface, \Serializable
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
     * @Assert\NotBlank()
     * @ORM\Column(name="ua_first_name", type="string", length=30)
     */
    private $auFirstName;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="ua_last_name", type="string", length=30)
     */
    private $auLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="ua_email_address", type="string", length=60, unique=true)
     */
    private $auEmailAddress;

    /**
     * @ORM\Column(name="ua_username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="ua_password", type="string", length=64, unique=true)
     */
    private $password;

    /**
     * @ORM\Column(name="ua_is_active", type="boolean")
     */
    private $isActive;

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
     * Set auFirstName
     *
     * @param  string   $auFirstName
     * @return UserAuth
     */
    public function setAuFirstName($auFirstName)
    {
        $this->auFirstName = $auFirstName;

        return $this;
    }

    /**
     * Get auFirstName
     *
     * @return string
     */
    public function getAuFirstName()
    {
        return $this->auFirstName;
    }

    /**
     * Set auLastName
     *
     * @param  string   $auLastName
     * @return UserAuth
     */
    public function setAuLastName($auLastName)
    {
        $this->auLastName = $auLastName;

        return $this;
    }

    /**
     * Get auLastName
     *
     * @return string
     */
    public function getAuLastName()
    {
        return $this->auLastName;
    }

    /**
     * Set auEmailAddress
     *
     * @param  string   $auEmailAddress
     * @return UserAuth
     */
    public function setAuEmailAddress($auEmailAddress)
    {
        $this->auEmailAddress = $auEmailAddress;

        return $this;
    }

    /**
     * Get auEmailAddress
     *
     * @return string
     */
    public function getAuEmailAddress()
    {
        return $this->auEmailAddress;
    }

    /**
     * Set auUsername
     *
     * @param  string   $auUsername
     * @return UserAuth
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get auUsername
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param  string   $auPassword
     * @return UserAuth
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
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
     * Set isActive
     *
     * @param  boolean  $isActive
     * @return UserAuth
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
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

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->auFirstName,
            $this->auLastName,
            $this->username,
            $this->password,
            $this->isActive
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->auFirstName,
            $this->auLastName,
            $this->username,
            $this->password,
            $this->isActive
        ) = unserialize($serialized);
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
}
