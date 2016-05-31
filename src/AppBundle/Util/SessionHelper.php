<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

class SessionHelper
{
    private $anonymousId;
    private $session;
    private $logger;

    public function startSession()
    {
        $this->session = new Session(new PhpBridgeSessionStorage());
        $this->session->start();
        
        return $this;
    }

    public function generateAnonId()
    {
        $random     = random_bytes(10);
        $anonUserId = base64_encode($random);

        return $anonUserId;
    }

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
