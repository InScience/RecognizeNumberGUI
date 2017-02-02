<?php

// src/AppBundle/Form/TaskType.php
namespace GateAdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GateAdminBundle\Form\PersonEntityType;


class VehicleOwner1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
                
            ->add('owners', EntityType::class, array( 'data_class' => 'GateAdminBundle\Entity\Owner',
                'label' => 'Savininkas',
                'label_attr' => array(
                
                    'class' => 'col-sm-4 control-label'
                
            ),
                 'attr' => array(
                'class' => 'form-control'),
    'class' => 'GateAdminBundle:Owner',
   // 'property' => 'Owner.nameSurname',
    // use the User.username property as the visible option string
    'choice_label' => 'nameSurname',

    // used to render a select box, check boxes or radios
    // 'multiple' => true,
    // 'expanded' => true,
      'mapped' => false
))
            
          
         ->getForm();
    }
    
   public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
        'data_class' => 'GateAdminBundle\Entity\Owner',
    ));
}
   

}
