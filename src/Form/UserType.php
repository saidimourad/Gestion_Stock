<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Nom'),'label' => 'Nom ' ))
            ->add('prenom',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Prénom'),'label' => 'Prénom' ))
            ->add('cin',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Catre d\'identité'),'label' => 'Catre d\'identité' ))
          // ->add('datenassance')
          // ->add('datenassance',DateType::class )
            ->add('datenassance', DateType::class, [
                'widget' => 'single_text','label' => 'Date de naissance'
            ])
            ->add('adresse',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Adresse'),'label' => 'Adresse' ))
           // ->add('tel')





            ->add('tel',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Numéro de téléphone','pattern'=>'[0-9]{2}[0-9]{3}[0-9]{3}')  ,'label' => 'Numéro de téléphone' ))

            ->add('email',EmailType::class, array('attr' => array( 'required' => true,'placeholder'=> 'email@example.com'),'label' => 'Email' ))
            ->add('password', PasswordType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Mot de passe'),'label' => 'Mot de passe' ))

            ->add('confirm_password',PasswordType::class ,array('attr' => array( 'required' => true,'placeholder'=> 'Confirmer mot de passe'),'label' => 'Confirmer le mot de passe' ))

            ->add('sexe', ChoiceType::class, array(
                'choices'  => array(
                    'Homme' =>  'Homme',
                    'Femme' => 'Femme',
                )))
            ->add('etatcivil', ChoiceType::class, array(
                'choices'  => array(
                    'Célibataire ' =>  'célibataire ',
                    'Marié(e)' => 'marié(e)',
                    'Divorcé(e)' => 'divorcé(e)',
                    'Veuf' => 'veuf',
                    'Veuve' => 'veuve',

                ),'label' => 'Etat civil'))


            ->add('dateembauche', DateType::class, [
                'widget' => 'single_text','label' => 'Date d\'embauche'
            ])

            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => User::ROLE_ADMIN,
                    'Directeur' => User::ROLE_DIRECTEUR,
                    'Chef de bureau' => User::ROLE_CHEFBUREAU,
                    'Chef d unité' => User::ROLE_CHEFUNITE,
                    'Magasinier' => User::ROLE_MAGASINIER,

                ],
                'multiple' => true,
                'required' => true,
                'label' => 'Rôle'
            ])
           // ->add('isActive')
            ->add('isActive', CheckboxType::class, [
                'label'    => 'Utilisateur Active',
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
