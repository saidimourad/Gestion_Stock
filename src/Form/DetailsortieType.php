<?php

namespace App\Form;

use App\Entity\Detailsortie;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Article;
use Symfony\Component\Security\Core\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class DetailsortieType extends AbstractType
{


    private $articleRepository;
    private $security;
    public function __construct( ArticleRepository $articleRepository, Security $security)
    {
        $this->articleRepository = $articleRepository;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('article', EntityType::class, ['class'=>Article::class, 'choices' => $this->articleRepository->findArticleByuser($this->security->getUser()->getId()), 'choice_label' => 'nom_art',  'label' => 'Article', 'attr' => array('class'=>'select2 form-control',  'required' => true) ])
            ->add('qtesortie', TextType::class , array('attr' => array( 'required' => true, 'type'=>'number','min'=>'0.001','title'=>'Vous devez saisir un nombre valide.', 'pattern'=>'\d+(\.\d{3})?',  'placeholder'=> '0.000',  'class'=>'form-control'),'label' => 'Quantité' ) )
           // ->add('message')
            ->add('message', TextType::class , array('attr' => array( 'required' => false,'autocomplete'=>'off', 'class'=>'form-control-plaintext'),'label' => ' ','disabled'=>true ) )

        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Detailsortie::class,
            'cascade_validation' => true,
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_exp';
    }
    /**
* @param FormEvent $event
*/

}
