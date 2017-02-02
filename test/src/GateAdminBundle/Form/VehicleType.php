<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GateAdminBundle\Form\PersonEntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('licensenum', 'text', array(  
            'label' => 'Registracijos numeris',
            'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
        ->add('brand', 'text', array(
            'label' => 'Markė',
            'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
        ->add('model', 'text', array(
            'label' => 'Modėlis',
            'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
                
                
           ->add('did', HiddenType::class, array(
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
    
   
   public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'GateAdminBundle\Entity\Vehicle',
    ));
}

}
