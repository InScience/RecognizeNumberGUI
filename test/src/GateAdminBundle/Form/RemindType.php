<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
class RemindType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
            'label' => 'el. paštas',
            'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
        
      
        ->add('save', SubmitType::class, array('label' => 'Siųsti',
           'attr' => array( 'class' => 'btn btn-default' )))
          //->add('save', 'submit', array('required' => true))        
         ->getForm();
    }
    
    
    

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'GateAdminBundle\Entity\Administrator',
    ));
}
}
