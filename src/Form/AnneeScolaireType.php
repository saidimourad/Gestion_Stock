<?php

namespace App\Form;

use App\Entity\AnneeScolaire;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnneeScolaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->add('designation')
            ->add('designation',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Année Scolaire'),'label' => 'Année Scolaire' ))

            -> add('actif',ChoiceType::class, [
                'choices' => ['Actif' => 1, 'Inactif' => 0],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnneeScolaire::class,
        ]);
    }
}
