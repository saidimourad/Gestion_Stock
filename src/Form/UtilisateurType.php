<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Fonction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('cin')
            ->add('tel')
            ->add('email')
            ->add('password', PasswordType::class)
            ->add('confirm_password')

           -> add('actif',ChoiceType::class, [
                'choices' => ['Actif' => 1, 'Inactif' => 0],])

            ->add('date_naissance')
            ->add('fonction', EntityType::class, array('class' => Fonction::class, 'choice_label' => 'fonction'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
