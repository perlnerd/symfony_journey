<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UserAuth
 *
 * @ORM\Table("user_auth")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserAuthRepository")
 * @UniqueEntity("auEmailAddress")
 */
class UserAuth implements UserInterface, \Serializable
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
     * @ORM\Column(name="ua_email_address", type="string", length=60, unique=true)
     */
    private $auEmailAddress;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="ua_password", type="string", length=64, unique=true)
     */
    private $password;

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

    public function getUsername()
    {
        return $this->auEmailAddress;
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
            $this->auEmailAddress,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->auEmailAddress,
            $this->password,
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
