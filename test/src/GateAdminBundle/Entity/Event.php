<?php

namespace GateAdminBundle\Entity;

/**
 * Event
 */
class Event
{
    /**
     * @var int
     */
    private $eid;

    /**
     * @var int
     */
    private $sid;

    /**
     * @var int
     */
    private $gaid;

    /**
     * @var int
     */
    private $vid;

    /**
     * @var int
     */
    private $rpid;

    /**
     * @var \DateTime
     */
    private $eventDate;

    /**
     * @var float
     */
    private $confidence;

    /**
     * @var string
     */
    private $recnumber;

    /**
     * @var int
     */
    private $status;


    /**
     * Get eID
     *
     * @return int
     */
    public function getEID()
    {
        return $this->eid;
    }

    /**
     * Set sID
     *
     * @param integer $sID
     *
     * @return Event
     */
    public function setSID($sID)
    {
        $this->sid = $sID;

        return $this;
    }

    /**
     * Get sID
     *
     * @return int
     */
    public function getSID()
    {
        return $this->sid;
    }

    /**
     * Set gaID
     *
     * @param integer $gaID
     *
     * @return Event
     */
    public function setGaID($gaID)
    {
        $this->gaid = $gaID;

        return $this;
    }

    /**
     * Get gaID
     *
     * @return int
     */
    public function getGaID()
    {
        return $this->gaid;
    }

    /**
     * Set vID
     *
     * @param integer $vID
     *
     * @return Event
     */
    public function setVID($vID)
    {
        $this->vid = $vID;

        return $this;
    }

    /**
     * Get vID
     *
     * @return int
     */
    public function getVID()
    {
        return $this->vid;
    }

    /**
     * Set rpID
     *
     * @param integer $rpID
     *
     * @return Event
     */
    public function setRpID($rpID)
    {
        $this->rpid = $rpID;

        return $this;
    }

    /**
     * Get rpID
     *
     * @return int
     */
    public function getRpID()
    {
        return $this->rpid;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     *
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set confidence
     *
     * @param float $confidence
     *
     * @return Event
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;

        return $this;
    }

    /**
     * Get confidence
     *
     * @return float
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Set recNumber
     *
     * @param string $recNumber
     *
     * @return Event
     */
    public function setRecNumber($recNumber)
    {
        $this->recnumber = $recNumber;

        return $this;
    }

    /**
     * Get recNumber
     *
     * @return string
     */
    public function getRecNumber()
    {
        return $this->recnumber;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
