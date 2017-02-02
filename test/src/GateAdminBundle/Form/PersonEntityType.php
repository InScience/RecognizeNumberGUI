<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PersonEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       ->add('did', EntityType::class, array(
                'label_attr' => array(
                
                    'class' => 'col-sm-2 control-label'
                
            ),
    'class' => 'GateAdminBundle:Owner',
    'property' => 'Owner.nameSurname',
    // use the User.username property as the visible option string
    'choice_label' => 'nameSurname',

    // used to render a select box, check boxes or radios
    // 'multiple' => true,
    // 'expanded' => true,
));
       
    }
    
    
    

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'GateAdminBundle\Entity\Owner',
    ));
}
}
