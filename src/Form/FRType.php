<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class FRType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('nomste',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Nom Société'),'label' => 'Nom de Société' ))
            ->add('mfste',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Matricule Fiscale'),'label' => 'Matricule Fiscale' ))
            ->add('gerantste',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Gérant de Société'),'label' => 'Gérant de Société' ))
            ->add('adresse',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Adresse'),'label' => 'Adresse' ))
            ->add('tel',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Numéro de téléphone','pattern'=>'[0-9]{2}[0-9]{3}[0-9]{3}')  ,'label' => 'Numéro de téléphone' ))
            ->add('email',EmailType::class, array('attr' => array( 'required' => true,'placeholder'=> 'email@example.com'),'label' => 'Email' ))
            ->add('activiteste',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Activité de Société'),'label' => 'Activité de Société' ))
            ->add('password', PasswordType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Mot de passe'),'label' => 'Mot de passe' ))

            ->add('confirm_password',PasswordType::class ,array('attr' => array( 'required' => true,'placeholder'=> 'Confirmer mot de passe'),'label' => 'Confirmer le mot de passe' ))


            ->add('isActive', CheckboxType::class, [
                'label'    => 'Fournisseur Active',
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
