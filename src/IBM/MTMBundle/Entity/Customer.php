<?php

namespace IBM\MTMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 */
class Customer
{
    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var \IBM\MTMBundle\Entity\Balance
     */
    private $balance;

    /**
     * @var \IBM\MTMBundle\Entity\Pin
     */
    private $pin;


    /**
     * Set account
     *
     * @param string $account
     * @return Customer
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
     * Set status
     *
     * @param string $status
     * @return Customer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Customer
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set balance
     *
     * @param \IBM\MTMBundle\Entity\Balance $balance
     * @return Customer
     */
    public function setBalance(\IBM\MTMBundle\Entity\Balance $balance = null)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return \IBM\MTMBundle\Entity\Balance 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set pin
     *
     * @param \IBM\MTMBundle\Entity\Pin $pin
     * @return Customer
     */
    public function setPin(\IBM\MTMBundle\Entity\Pin $pin = null)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return \IBM\MTMBundle\Entity\Pin 
     */
    public function getPin()
    {
        return $this->pin;
    }
    
    public function __toString()
    {
    	return $this->firstName.' '.$this->lastName;
    }
}
