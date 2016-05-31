<?php

namespace AppBundle\Util;

use AppBundle\Entity\Journey as JourneyLog;
use Doctrine\ORM\EntityManager;
use DateTime;

class JourneyLogger
{
    private $validEventTypeList;
    private $em;
    private $today;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->today = date('Y-m-d');
    }

    /**
     * Gets the value of validEventTypeList.
     *
     * @return mixed
     */
    public function getValidEventTypeList()
    {
        return $this->validEventTypeList;
    }

    /**
     * Sets the value of validEventTypeList.
     *
     * @param array $validEventTypeList the valid event type list
     *
     * @return self
     */
    
    public function setValidEventTypeList(array $validEventTypeList)
    {
        $this->validEventTypeList = $validEventTypeList;

        return $this;
    }

    /**
     * Returns a user's journey by email address
     * @param  string $email email address
     * @return array         user's journey
     */
    public function fetchReportByEmail($email)
    {
        $resultList = $this->em->getRepository('AppBundle:Journey')
            ->fetchReportByEmail($email);

        return $resultList;
    }

    /**
     * retrieves the result of a query to get a summary report of user events.
     * @param  string $date date to limit the results to in the format yyyy-mm-dd
     * @return array        Query result
     */
    public function fetchSummaryReportByDate($date)
    {
        if (! $date) {
            $date = $this->today;
        }
        
        $resultList = $this->em->getRepository('AppBundle:Journey')
            ->fetchSummaryReportByDate($date);

        return $resultList;
    }

    /**
     * The main logger function. Validates data and persists the entry to the DB.
     * @param  mixed $eventType  Integer or string representation of an event type
     * @param  integer $userId   numeric ID of the user
     * @param  string $anonId    random anonymous ID of unregistered user
     * @return boolean           true
     */
    public function logJourneyEvent($eventType, $userId)
    {
            $dateTime   = new DateTime("now");
            $journeyLog = new JourneyLog();
            $eventType = $this->isValidEventType($eventType);

            $journeyLog
                ->setUserId($userId)
                ->setEventTime($dateTime)
                ->setEventType($eventType);
            $this->em->persist($journeyLog);
            $this->em->flush();

            return true;
    }

    /**
     * confirm that a valid event is being logged.
     * @param  mixed  $eventType Integer or string representation of an Event Type key (int) or value (string).
     *  ie: 1 or "landing"
     * @return integer The integer representation of the valid event type or 0 if not found.
     */
    private function isValidEventType($eventType)
    {
        if (is_int($eventType) || ctype_digit($eventType)) {
            if (array_key_exists($eventType, $this->validEventTypeList)) {
                return (int) $eventType;
            }
        }

        $flipped = array_flip($this->validEventTypeList);

        if (array_key_exists($eventType, $flipped)) {
            return (int) $flipped[$eventType];
        }

        return 0;
    }

    public function convertAnonToRegisteredUsers($userId, $anonId)
    {
        $q = $this->em
            ->createQuery('update AppBundle:Journey j set j.userId = :userid WHERE j.userId = :anonid')
            ->setParameter('userid', $userId)
            ->setParameter('anonid', $anonId);
        $numUpdated = $q->execute();
        
        return $numUpdated;

    }
}
