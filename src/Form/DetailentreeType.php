<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DetailentreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
         {
    $builder
            ->add('article' , EntityType::class ,array('class'=>Article::class,'choice_label' => 'nom_art','attr' => array('class'=>'select2')))
            ->add('qteentree', TextType::class , array('attr' => array( 'required' => true, 'type'=>'number','min'=>'0.001','title'=>'Vous devez saisir un nombre  valide.', 'pattern'=>'\d+(\.\d{3})?','autocomplete'=>'off',  'placeholder'=> '0.000',  'class'=>'form-control'),'label' => 'Quantité' ) )
            ->add('prixentree', TextType::class, array('attr' => array( 'required' => true, 'type'=>'number','min'=>'0.001' ,'title'=>'Vous devez saisir un nombre  valide.', 'pattern'=>'\d+(\.\d{3})?','autocomplete'=>'off', 'placeholder'=> '0.000', 'class'=>'form-control'),'label' => 'Prix' ))  ;
         }


    public function configureOptions(OptionsResolver $resolver)
     {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Detailentree',
            'cascade_validation' => true,
        ));
     }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_exp';
    }
}
