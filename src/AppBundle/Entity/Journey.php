<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Journey
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\JourneyRepository")
 */
class Journey
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
     * @ORM\Column(name="user_id", type="string", length=64)
     */
    private $userId = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_time", type="datetime")
     */
    private $eventTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="event_type", type="smallint")
     */
    private $eventType;


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
     * Set eventTime
     *
     * @param \DateTime $eventTime
     * @return Journey
     */
    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    /**
     * Get eventTime
     *
     * @return \DateTime
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }

    /**
     * Set eventType
     *
     * @param string $eventType
     * @return Journey
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Gets the value of anonId.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Sets the value of userId.
     *
     * @param string $userId the anon id
     *
     * @return Journey
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}
