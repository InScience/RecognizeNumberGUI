<?php

namespace GateAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Vehicle
 */
class Vehicle
{
    
     public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        
       
        $metadata->addPropertyConstraint('licensenum', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));
         $metadata->addPropertyConstraint('model', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));
          $metadata->addPropertyConstraint('brand', new Assert\NotNull(array(
            'message' => 'Laukas negali būti tuščias',
        )));
          
          
          
             $metadata->addPropertyConstraint('licensenum', new Assert\Length(array(
            'min'        => 1,
            'max'        => 10,
            'minMessage' => 'Registracijos numeris turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Registracijos numeris negali būti ilgesnis, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
            $metadata->addPropertyConstraint('model', new Assert\Length(array(
            'min'        => 0,
            'max'        => 15,
            'minMessage' => 'Markė turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Markė negali būti ilgesnė, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
            $metadata->addPropertyConstraint('brand', new Assert\Length(array(
            'min'        => 0,
            'max'        => 15,
            'minMessage' => 'Modelis turi turėti bent {{ limit }} simbolius',
            'maxMessage' => 'Modelis numeris negali būti ilgesnis, nei {{ limit }} simbolių',
            'groups'  => array('Length'),
        )));
                
            $metadata->setGroupSequence(array('Vehicle', 'Strict', 'Length'));
    }
    /**
     * @var int
     */
     public $vid;

    /**
     * @var int
     */
     public $did;

    /**
     * @var string
     */
    private $licensenum;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $model;

    /**
     * @var int
     */
    private $vactive;


    /**
     * Get id
     *
     * @return int
     */
    public function getVID()
    {
        return $this->vid;
    }

    /**
     * Set dID
     *
     * @param integer $dID
     *
     * @return Vehicle
     */
    public function setDID($dID)
    {
        $this->did = $dID;

        return $this;
    }

    /**
     * Get dID
     *
     * @return int
     */
    public function getDID()
    {
        return $this->did;
    }

    /**
     * Set licensenum
     *
     * @param string $licensenum
     *
     * @return Vehicle
     */
    public function setLicensenum($licensenum)
    {
        $this->licensenum = $licensenum;

        return $this;
    }

    /**
     * Get licensenum
     *
     * @return string
     */
    public function getLicensenum()
    {
        return $this->licensenum;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Vehicle
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Vehicle
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set vActive
     *
     * @param integer $vActive
     *
     * @return Vehicle
     */
    public function setVActive($vActive)
    {
        $this->vactive = $vActive;

        return $this;
    }

    /**
     * Get vActive
     *
     * @return int
     */
    public function getVActive()
    {
        return $this->vactive;
    }
    
   
   
    
    /**
     * @var integer
     */
    private $showveh;


    /**
     * Set showveh
     *
     * @param integer $showveh
     *
     * @return Vehicle
     */
    public function setShowveh($showveh)
    {
        $this->showveh = $showveh;

        return $this;
    }

    /**
     * Get showveh
     *
     * @return integer
     */
    public function getShowveh()
    {
        return $this->showveh;
    }
}
