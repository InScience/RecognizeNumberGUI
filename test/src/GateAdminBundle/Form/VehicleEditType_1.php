<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
class VehicleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('licenseNum', 'text', array(  'data_class' => 'GateAdminBundle\Entity\Vehicle',
            'label' => 'Registracijos numeris',
            'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
        ->add('brand', 'text', array( 'data_class' => 'GateAdminBundle\Entity\Vehicle',
            'label' => 'Markė',
            'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
        ->add('model', 'text', array( 'data_class' => 'GateAdminBundle\Entity\Vehicle',
            'label' => 'Modėlis',
            'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
                
                
            ->add('owners', EntityType::class, array( 'data_class' => 'GateAdminBundle\Entity\Owner',
                'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
    'class' => 'GateAdminBundle:Owner',
    //'property' => 'Owner.nameSurname',
    // use the User.username property as the visible option string
    'choice_label' => 'nameSurname',

    // used to render a select box, check boxes or radios
    // 'multiple' => true,
    // 'expanded' => true,
))
                ->add('vid', HiddenType::class, array(
            'label' => ' ',
            'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        ))
            
            ->add('save', SubmitType::class, array( 'label' => 'Patvirtinti',
           'attr' => array( 'class' => 'btn btn-success')))
          //->add('save', 'submit', array('required' => true))    
         ->getForm();
    }
    
    
    


}
