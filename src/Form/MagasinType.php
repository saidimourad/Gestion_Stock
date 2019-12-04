<?php

namespace App\Form;

use App\Entity\Magasin;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MagasinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('designation',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Désignation magasin'),'label' => 'Désignation' ))
            ->add('adresse',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Adresse'),'label' => 'Adresse' ))

            ->add('region' , EntityType::class ,array('class'=>Region::class,'choice_label' => 'designation','label' => 'Région','attr' => array('class'=>'select2 form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Magasin::class,
        ]);
    }
}
