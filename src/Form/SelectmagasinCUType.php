<?php

namespace App\Form;
use App\Entity\Magasin;
use App\Repository\MagasinRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;








class SelectmagasinCUType extends AbstractType
{


    private $magasinRepository;

    private $security;

    public function __construct(MagasinRepository $magasinRepository, Security $security)
    {


        $this->magasinRepository = $magasinRepository;

        $this->security = $security;


    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder   ->add('magasin', EntityType::class, ['class' => Magasin::class, 'choices' => $this->magasinRepository->findMagasinByuserCU($this->security->getUser()->getId(), $this->security->getUser()->getRoles()), 'choice_label' => 'designation', 'label' => 'Magasin: ', 'attr' => array('class' => 'select2 form-control', 'required' => true)])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            /*            'data_class' => Magasin::class,*/
            'cascade_validation' => true,

        ]);
    }
}
