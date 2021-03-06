<?php

namespace IBM\MTMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trans
 */
class Trans
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $timeStart;

    /**
     * @var \DateTime
     */
    private $timeEnd;

    /**
     * @var \IBM\MTMBundle\Entity\Customer
     */
    private $customer;


    /**
     * Get id
     *
     * @return \int 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return Trans
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
     * Set amount
     *
     * @param string $amount
     * @return Trans
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Trans
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set timeStart
     *
     * @param \DateTime $timeStart
     * @return Trans
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    /**
     * Get timeStart
     *
     * @return \DateTime 
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }

    /**
     * Set timeEnd
     *
     * @param \DateTime $timeEnd
     * @return Trans
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * Get timeEnd
     *
     * @return \DateTime 
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    /**
     * Set customer
     *
     * @param \IBM\MTMBundle\Entity\Customer $customer
     * @return Trans
     */
    public function setCustomer(\IBM\MTMBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \IBM\MTMBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
