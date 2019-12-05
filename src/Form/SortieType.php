<?php

namespace App\Form;

use App\Entity\Repas;
use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\AnneeScolaireRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Proxies\__CG__\App\Entity\AnneeScolaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SortieType extends AbstractType
{


    private $anneeRepository;
    public function __construct(AnneeScolaireRepository $anneeRepository )
    {

        $this->anneeRepository = $anneeRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('repas' , EntityType::class ,array('class'=>Repas::class,'choice_label' => 'designation', 'attr' => array('class'=>'select2')))
        ->add('anneeScolaire', EntityType::class, ['class'=>AnneeScolaire::class, 'choices' => $this->anneeRepository->encours(), 'choice_label' => 'designation', 'attr' => array('class'=>'select2', 'required' => true) ])
        // this is the embeded form, the most important things are highlighted at the bottom
        ->add('detailsorties', CollectionType::class, [
            'entry_type' => DetailsortieType::class,
            'entry_options' => [
                'label' => false
            ],
            'by_reference' => false,
            // this allows the creation of new forms and the prototype too
            'allow_add' => true,
            // self explanatory, this one allows the form to be removed
            'allow_delete' => true,
            'prototype' => true,
            'label' => ' ',

        ]);


        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
            'csrf_protection'=>true,
        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {


        $data = $event->getData();
        if (isset($data['detailsorties']))
        {
            $data['detailsorties'] = array_values($data['detailsorties']);
            $event->setData($data);

        }

        else
        {
             echo '<script> alert("Manque détail de sortie")</script>';



        }
    }
}
