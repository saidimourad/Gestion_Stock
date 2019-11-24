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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ValidCommandeType extends AbstractType
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

            ->add('dateprevulivraison', DateType::class, ['widget' => 'single_text', 'label' => 'Date prévu de livraison'])
         //   ->add('userfr', EntityType::class, ['class'=>User::class, 'choices' => $this->frRepository->findAll(),  'label' => 'Fournisseur', 'attr' => array('class'=>'select2 form-control',  'required' => true) ])
         ->add('isValid', ChoiceType::class, array(
             'choices'  => array(
                 'Accepter' =>  '1',
                 'Refuser' => '0',
             )
         ,'label' => 'Etat de commande'
         ))
            ->add('userfr', EntityType::class, ['class'=>User::class, 'choices' => $this->frRepository->findByRole("ROLE_FOURNISSEUR"),  'label' => 'Fournisseur' ,'attr' => array('class'=>'select2 form-control',  'required' => true) ])

            // just a regular save button to persist the changes
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn  btn-success '
                ]
            ])

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
