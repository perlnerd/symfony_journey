<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class SessionHelper
{
    private $anonymousId;
    private $session;
    private $logger;

    /**
     * Initiate a symfony session.
     * @return Object SessionHelper
     */
    public function startSession()
    {
        $this->session = new Session(new PhpBridgeSessionStorage());
        $this->session->start();
        
        return $this;
    }

    /**
     * Create a random ID for use when tracking a non registered user
     * @return string  anonymous ID
     */
    public function generateAnonId()
    {
        $random     = random_bytes(10);
        $anonUserId = base64_encode($random);

        return $anonUserId;
    }

    /**
     * If anonymous_id is already set in the session, do nothing.  Otherwise create an anonymous_id in the session
     * @return Object SessionHelper
     */
    public function configureAnonId()
    {
        if (! $this->session->get('anonymous_id')) {
            $id = $this->generateAnonId();

            $this->setAnonymousId($id);
            $this->session->set('anonymous_id', $this->getAnonymousId());
            
            return $this;
        }
        
        $this->setAnonymousId($this->session->get('anonymous_id'));

        return $this;
    }

    /**
     * Gets the value of anonymousId.
     *
     * @return mixed
     */
    public function getAnonymousId()
    {
        return $this->anonymousId;
    }

    /**
     * Sets the value of anonymousId.
     *
     * @param mixed $anonymousId the anonymous id
     *
     * @return self
     */
    private function setAnonymousId($anonymousId)
    {
        $this->anonymousId = $anonymousId;

        return $this;
    }
}
