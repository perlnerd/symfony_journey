<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportCsv
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ImportCsv
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
     * @ORM\Column(name="ic_first_name", type="string", length=30)
     */
    private $icFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="ic_last_name", type="string", length=30)
     */
    private $icLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="ic_email_address", type="string", length=60)
     */
    private $icEmailAddress;


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
     * Set icFirstName
     *
     * @param string $icFirstName
     * @return ImportCsv
     */
    public function setIcFirstName($icFirstName)
    {
        $this->icFirstName = $icFirstName;

        return $this;
    }

    /**
     * Get icFirstName
     *
     * @return string 
     */
    public function getIcFirstName()
    {
        return $this->icFirstName;
    }

    /**
     * Set icLastName
     *
     * @param string $icLastName
     * @return ImportCsv
     */
    public function setIcLastName($icLastName)
    {
        $this->icLastName = $icLastName;

        return $this;
    }

    /**
     * Get icLastName
     *
     * @return string 
     */
    public function getIcLastName()
    {
        return $this->icLastName;
    }

    /**
     * Set icEmailAddress
     *
     * @param string $icEmailAddress
     * @return ImportCsv
     */
    public function setIcEmailAddress($icEmailAddress)
    {
        $this->icEmailAddress = $icEmailAddress;

        return $this;
    }

    /**
     * Get icEmailAddress
     *
     * @return string 
     */
    public function getIcEmailAddress()
    {
        return $this->icEmailAddress;
    }
}
