<?php

namespace App\Form;

use App\Entity\AnneeScolaire;
use App\Entity\User;
use App\Repository\AnneeScolaireRepository;
use Proxies\__CG__\App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\UserRepository;

class AffecterChefbureauType extends AbstractType
{

    private $userRepository;
    private $anneeRepository;
    public function __construct(AnneeScolaireRepository $anneeRepository, UserRepository $userRepository )
    {
        $this->userRepository = $userRepository;
        $this->anneeRepository = $anneeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          //  ->add('user' , EntityType::class ,array('class'=>User::class,'choice_label' => 'email', 'attr' => array('class'=>'select2 form-control') ))
            ->add('user', EntityType::class, ['class'=>User::class, 'choices' => $this->userRepository->findByRole("ROLE_CHEFBUREAU"),  'label' => 'Chef de bureau' ,'attr' => array('class'=>'select2 form-control',  'required' => true) ])

            ->add('region' , EntityType::class ,array('class'=>Region::class,'choice_label' => 'designation','label' => 'Région', 'attr' => array('class'=>'select2 form-control') ))
            ->add('anneeScolaire', EntityType::class, ['class'=>AnneeScolaire::class, 'choices' => $this->anneeRepository->encours(), 'choice_label' => 'designation', 'attr' => array('class'=>'select2 form-control', 'required' => true) ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
