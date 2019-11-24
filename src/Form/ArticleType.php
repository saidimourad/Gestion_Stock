<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Fonction;
use App\Form\CategorieType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_art',TextType::class, array('attr' => array( 'required' => false,'placeholder'=> 'Désignation article'),'label' => 'Désignation article' ))
            ->add('unite',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Unité'),'label' => 'Unité' ))
            ->add('qte_min',TextType::class, array('attr' => array( 'required' => true,'placeholder'=> 'Quantité minimale'),'label' => 'Quantité minimale'  ))
            ->add('categorie' , EntityType::class ,array('class'=>Categorie::class,'choice_label' => 'nom_cat', 'required' => true,  'label' => 'Catégorie','attr' => array('class'=>'select2 form-control')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'attr'=>array('novalidate'=>'novalidate')
        ));
    }
}
