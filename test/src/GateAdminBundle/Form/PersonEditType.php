<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
class PersonEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
            'label' => 'Vardas',
            'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
              ->add('surname', 'text', array(
            'label' => 'Pavardė',
            'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )  
                
        ->add('phonenumber', 'text', array( 
            'label' => 'Tel. Numeris',
            'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
             'attr' => array(
                'class' => 'form-control')
        )
            
             
            )
        ->add('adress', 'text', array(
            'label' => 'Adresas',
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
        ->add('save', SubmitType::class, array(  'label' => 'Patvirtinti',
           'attr' => array( 'class' => 'btn btn-success')))
          //->add('save', 'submit', array('required' => true))    
         ->getForm();
    }
    
    
    

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'GateAdminBundle\Entity\Owner',
    ));
}
}
