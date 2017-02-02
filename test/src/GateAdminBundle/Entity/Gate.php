<?php

namespace GateAdminBundle\Entity;

/**
 * Gate
 */
class Gate
{
    /**
     * @var string
     */
    private $gateadresss;

    /**
     * @var integer
     */
    private $inorout;

    /**
     * @var integer
     */
    private $gatekey;

    /**
     * @var integer
     */
    private $gaid;


    /**
     * Set gateadresss
     *
     * @param string $gateadresss
     *
     * @return Gate
     */
    public function setGateadresss($gateadresss)
    {
        $this->gateadresss = $gateadresss;

        return $this;
    }

    /**
     * Get gateadresss
     *
     * @return string
     */
    public function getGateadresss()
    {
        return $this->gateadresss;
    }

    /**
     * Set in/out
     *
     * @param integer $inorout
     *
     * @return Gate
     */
    public function setInOrOut($inorout)
    {
        $this->inorout = $inorout;

        return $this;
    }

    /**
     * Get in/out
     *
     * @return integer
     */
    public function getInOrOut()
    {
        return $this->in/out;
    }

    /**
     * Set gatekey
     *
     * @param integer $gatekey
     *
     * @return Gate
     */
    public function setGatekey($gatekey)
    {
        $this->gatekey = $gatekey;

        return $this;
    }

    /**
     * Get gatekey
     *
     * @return integer
     */
    public function getGatekey()
    {
        return $this->gatekey;
    }

    /**
     * Get gaid
     *
     * @return integer
     */
    public function getGaid()
    {
        return $this->gaid;
    }
}

