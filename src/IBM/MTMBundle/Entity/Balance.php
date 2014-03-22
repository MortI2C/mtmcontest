<?php

namespace IBM\MTMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Balance
 */
class Balance
{
    /**
     * @var string
     */
    private $account;

    /**
     * @var string
     */
    private $balance;


    /**
     * Set account
     *
     * @param string $account
     * @return Balance
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
     * Set balance
     *
     * @param string $balance
     * @return Balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return string 
     */
    public function getBalance()
    {
        return $this->balance;
    }
}
