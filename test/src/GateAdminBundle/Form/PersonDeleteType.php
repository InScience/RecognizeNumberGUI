<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PersonDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('did', HiddenType::class, array(
            'label' => 'Ar tikrai norite ištrinti asmenį?',
            'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        ))
             
        ->add('save', SubmitType::class, array( 'label' => 'Patvirtinti',
           'attr' => array(  'class' => 'btn btn-success')))
          //->add('save', 'submit', array('required' => true))    
         ->getForm();
    }
    
    
    


}
