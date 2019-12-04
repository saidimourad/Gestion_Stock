<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Magasin;
use App\Entity\User;
use App\Repository\MagasinRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Repository\AnneeScolaireRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Proxies\__CG__\App\Entity\AnneeScolaire;
use Symfony\Component\Security\Core\Security;


use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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

           // ->add('datelivraison', DateType::class, ['widget' => 'single_text'])
            //->add('userfr', EntityType::class, ['class'=>User::class, 'choices' => $this->frRepository->findAll(), 'choice_label' => 'nomste',  'label' => 'Fournisseur', 'attr' => array('class'=>'select2 form-control',  'required' => true) ])




           // ->add('dateCommande', DateType::class, ['widget' => 'single_text'])
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
            // just a regular save button to persist the changes
           // ->add('Enregistrer', SubmitType::class, [
//'attr' => [
              //      'class' => 'btn  btn-outline-success float-right'
//]
//])

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'cascade_validation' => true,

        ]);
    }
}
