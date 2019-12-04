<?php

namespace App\Form;

use App\Entity\Lingecommande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Article;



class LingnecommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article' , EntityType::class ,array('class'=>Article::class,'choice_label' => 'nom_art','attr' => array('class'=>'select2 form-control')))
            ->add('qtecommande', TextType::class , array('attr' => array( 'required' => true, 'type'=>'number','min'=>'0.001','title'=>'Vous devez saisir un nombre  décimal.', 'pattern'=>'\d+(\.\d{3})?',  'placeholder'=> '0.000',  'class'=>'form-control'),'label' => 'Quantité' ) )


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lingecommande::class,
            'cascade_validation' => true,

        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_commande';
    }
    /**
     * @param FormEvent $event
     */
}
