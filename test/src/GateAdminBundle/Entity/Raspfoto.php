<?php

namespace GateAdminBundle\Entity;

/**
 * Raspfoto
 */
class Raspfoto
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $imagepath;

    /**
     * @var integer
     */
    private $rpid;


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Raspfoto
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set imagepath
     *
     * @param string $imagepath
     *
     * @return Raspfoto
     */
    public function setImagepath($imagepath)
    {
        $this->imagepath = $imagepath;

        return $this;
    }

    /**
     * Get imagepath
     *
     * @return string
     */
    public function getImagepath()
    {
        return $this->imagepath;
    }

    /**
     * Get rpid
     *
     * @return integer
     */
    public function getRpid()
    {
        return $this->rpid;
    }
}

