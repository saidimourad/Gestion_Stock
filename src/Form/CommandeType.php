<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Magasin;
use App\Repository\MagasinRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\AnneeScolaireRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Proxies\__CG__\App\Entity\AnneeScolaire;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CommandeType extends AbstractType
{


    private $anneeRepository;
    private $magasinRepository;
    private $frRepository;
    private $security;
    public function __construct(AnneeScolaireRepository $anneeRepository, MagasinRepository $magasinRepository, Security $security, UserRepository $frRepository)
    {

        $this->anneeRepository = $anneeRepository;
        $this->magasinRepository = $magasinRepository;
        $this->frRepository = $frRepository;

        $this->security = $security;


    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder


            ->add('magasin', EntityType::class, ['class'=>Magasin::class, 'choices' => $this->magasinRepository->findMagasinByuserCB($this->security->getUser()->getId()), 'choice_label' => 'designation',  'label' => 'Magasin', 'attr' => array('class'=>'select2 form-control',  'required' => true) ])
            ->add('anneeScolaire', EntityType::class, ['class'=>AnneeScolaire::class, 'choices' => $this->anneeRepository->encours(), 'choice_label' => 'designation', 'attr' => array('class'=>'select2 form-control', 'required' => true) ])
            // this is the embeded form, the most important things are highlighted at the bottom
            ->add('lingecommandes', CollectionType::class, [
                'entry_type' => LingnecommandeType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                // this allows the creation of new forms and the prototype too
                'allow_add' => true,
                // self explanatory, this one allows the form to be removed
                'allow_delete' => true,
                'label' => ' ',

            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
          //  'cascade_validation' => true,

        ]);
    }

    public function onPreSubmit(FormEvent $event)
    {

/*
     //  if ($event->getData()) {

            $data = $event->getData();
            $data['lingecommandes'] = array_values($data['lingecommandes']);
            $event->setData($data);
      //  }*/



       $data = $event->getData();
        if (isset($data['lingecommandes']))
        {
            $data['lingecommandes'] = array_values($data['lingecommandes']);
            $event->setData($data);

        }

        else
        {
            echo '<script> alert("Manque détail de commande")</script>';



        }





        /*  $data = $event->getData();
          if (isset($data['lingecommandes']))
          {
              $data['lingecommandes'] = array_values($data['lingecommandes']);
              $event->setData($data);

          }

          else
          {
              echo '<script> alert("Manque détail de la commande")</script>';


          }*/
    }
}
