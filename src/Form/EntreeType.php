<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Entree;
use App\Repository\CommandeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\AnneeScolaireRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Security\Core\Security;
use Proxies\__CG__\App\Entity\AnneeScolaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;


class EntreeType extends AbstractType
{
    private $userRepository;
    private $anneeRepository;
    private $commandeRepository;
    private $security;
    public function __construct(AnneeScolaireRepository $anneeRepository, UserRepository $userRepository, CommandeRepository $commandeRepository , Security $security)
    {
        $this->userRepository = $userRepository;
        $this->anneeRepository = $anneeRepository;
        $this->commandeRepository = $commandeRepository;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('commande', EntityType::class, ['class'=>Commande::class, 'choices' => $this->commandeRepository->selectCommandeByMG($this->security->getUser()->getId()),  'label' => 'Commande','attr' => array('class'=>'select2 ',  'required' => true) ])
            ->add('anneeScolaire', EntityType::class, ['class'=>AnneeScolaire::class, 'choices' => $this->anneeRepository->encours(), 'choice_label' => 'designation', 'attr' => array('class'=>'select2 ', 'required' => true) ])
            ->add('detailentrees', CollectionType::class, [
                'entry_type' => DetailentreeType::class,
                'entry_options' => [
                    'label' => false ],
                'by_reference' => false,
                // this allows the creation of new forms and the prototype too
                'allow_add' => true,
                // self explanatory, this one allows the form to be removed
                'allow_delete' => true,
                'label' => ' ',
                'attr' => array('required' => true) ])


        ;
        $builder ->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
         //   'cascade_validation' => true,
        ]);
    }
    public function onPreSubmit(FormEvent $event)
    {


        $data = $event->getData();
        if (isset($data['detailentrees']))
        {
            $data['detailentrees'] = array_values($data['detailentrees']);
            $event->setData($data);

        }

        else
        {
            echo '<script> alert("Manque détail de l\'entrée")</script>';

        }
    }
   /* public function onPreSubmit(FormEvent $event)
    {
        if ($event->getData()) {

            $data = $event->getData();
            $data['detailentrees'] = array_values($data['detailentrees']);
            $event->setData($data);
        }
    }*/
}



