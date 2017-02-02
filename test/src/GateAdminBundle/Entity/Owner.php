<?php

namespace GateAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Owner
 */
class Owner
{
    
     public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
       // 'groups'  => array('Strict'),
        $metadata->addPropertyConstraint('name', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));
            $metadata->addPropertyConstraint('surname', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));
          $metadata->addPropertyConstraint('phonenumber', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));    
         $metadata->addPropertyConstraint('adress', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));    
         
         $metadata->addPropertyConstraint('name', new Assert\Regex(array(
            'pattern' => '/\d/',
            'match'   => false,
            'message' => 'Vardas negali turėti skaičių',
        )));
           $metadata->addPropertyConstraint('surname', new Assert\Regex(array(
            'pattern' => '/\d/',
            'match'   => false,
            'message' => 'Pavardė negali turėti skaičių',
        )));
         
           $metadata->addPropertyConstraint('phonenumber', new Assert\Type(array(
            'type'    => 'numeric',
            'message' => 'Įvestas numeris turi neleistinų simbolių',
        )));
         
         
           $metadata->addPropertyConstraint('name', new Assert\Regex(array(
            'pattern' => '/[\$\(\)\*\+\.\?\[\\\^\{\|!@%&_:;`<>,~#=\"\\/]/',
            'match'   => false,
            'message' => 'Negalima naudoti specialių simbolių',
            'groups'  => array('Strict'),  
        )));
        
        
           $metadata->addPropertyConstraint('surname', new Assert\Regex(array(
            'pattern' => '/[\$\(\)\*\+\.\?\[\\\^\{\|!@%&_:;`<>,~#=\"\\/]/',
            'match'   => false,
            'message' => 'Negalima naudoti specialių simbolių',
            'groups'  => array('Strict'),
        )));
        
           $metadata->addPropertyConstraint('phonenumber', new Assert\Regex(array(
            'pattern' => '/[\$\(\)\*\-\.\?\[\\\^\{\|!@%&_:;`<>,~#=\"\\/]/',
            'match'   => false,
            'message' => 'Negalima naudoti specialių simbolių',
            'groups'  => array('Strict'),
        )));
           
           
            $metadata->addPropertyConstraint('name', new Assert\Length(array(
            'min'        => 0,
            'max'        => 15,
            'minMessage' => 'Vardas turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Vardas negali būti ilgesnis, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
            $metadata->addPropertyConstraint('surname', new Assert\Length(array(
            'min'        => 0,
            'max'        => 15,
            'minMessage' => 'Pavardė turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Pavardė negali būti ilgesnė, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
            $metadata->addPropertyConstraint('phonenumber', new Assert\Length(array(
            'min'        => 6,
            'max'        => 15,
            'minMessage' => 'Telefono numeris turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Telefono numeris negali būti ilgesnis, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
                 $metadata->addPropertyConstraint('adress', new Assert\Length(array(
            'min'        => 6,
            'max'        => 30,
            'minMessage' => 'Adresas turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Adresas numeris negali būti ilgesnis, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
           
           
           
           $metadata->setGroupSequence(array('Owner', 'Strict', 'Length'));
    }
    
    
    /**
     * @var int
     */
    public $did;

    /**
     * @var int
     */
    private $aid;

    /**
     * @var string
     */
    public $name;

	/**
     * @var string
     */
    private $surname;
	
    /**
     * @var string
     */
    private $phonenumber;

    /**
     * @var string
     */
    private $adress;

    /**
     * @var \DateTime
     */
    private $regdate;

    
    /**
     * @var int
     */
    private $oactive;


    /**
     * Get id
     *
     * @return int
     */
    public function getDID()
    {
        return $this->did;
    }

    /**
     * Set aID
     *
     * @param integer $aID
     *
     * @return Owner
     */
    public function setAID($aID)
    {
        $this->aid = $aID;

        return $this;
    }

    /**
     * Get aID
     *
     * @return int
     */
    public function getAID()
    {
        return $this->aid;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Owner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * Set surname
     *
     * @param string $surname
     *
     * @return Owner
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }
    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return Owner
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Owner
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set regDate
     *
     * @param \DateTime $regDate
     *
     * @return Owner
     */
    public function setRegDate($regDate)
    {
        $this->regdate = $regDate;

        return $this;
    }

    /**
     * Get regDate
     *
     * @return \DateTime
     */
    public function getRegDate()
    {
        return $this->regdate;
    }


    /**
     * Set oActive
     *
     * @param integer $oActive
     *
     * @return Owner
     */
    public function setOActive($oActive)
    {
        $this->oactive = $oActive;

        return $this;
    }

    /**
     * Get oActive
     *
     * @return int
     */
    public function getOActive()
    {
        return $this->oactive;
    }
    
    public function getNameSurname()
{
    return sprintf('%s %s', $this->surname, $this->name);
}
    
    /**
     * @var integer
     */
    private $showowner;


    /**
     * Set showowner
     *
     * @param integer $showowner
     *
     * @return Owner
     */
    public function setShowowner($showowner)
    {
        $this->showowner = $showowner;

        return $this;
    }

    /**
     * Get showowner
     *
     * @return integer
     */
    public function getShowowner()
    {
        return $this->showowner;
    }
}
