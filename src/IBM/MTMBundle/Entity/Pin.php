<?php

namespace IBM\MTMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pin
 */
class Pin
{
    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $pin;


    /**
     * Set account
     *
     * @param string $account
     * @return Pin
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set pin
     *
     * @param string $pin
     * @return Pin
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return string 
     */
    public function getPin()
    {
        return $this->pin;
    }
}
