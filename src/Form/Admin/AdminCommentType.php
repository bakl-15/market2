<?php

namespace App\Form\Admin;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('qualityRating', ChoiceType::class, [
            'choices' => [
                'Qualité' => [
                    '01 Etoile' => 1,
                    '02 Etoile' => 2,
                    '03 Etoile' => 3,
                    '04 Etoile' => 4,
                    '05 Etoile' => 5,
                ],
                
            ],
          
            'required' => false,
            'multiple' => false,
           
            'label' => 'Noter le produit',
            'attr' => [
                'class' => 'select-tag'
            ]
        ])
        
        ->add('priceRating', ChoiceType::class, [
            'choices' => [
                'Qualité' => [
                    '01 Etoile' => 1,
                    '02 Etoile' => 2,
                    '03 Etoile' =>3,
                    '04 Etoile' => 4,
                    '05 Etoile' => 5,
                ],
                
            ],
     
            'required' => false,
            'multiple' => false,
           
            'label' => 'Noter le produit',
            'attr' => [
                'class' => 'select-tag'
            ]
        ])
        ->add('content', CKEditorType::class,[
            'label' => 'Votre commentaire'
        ])
     
            ->add('product',EntityType::class,[
                'label' => 'Sélectionner un produit',
                'class' => Product::class,
                'required' => false,
                'attr' => [
                    'class' => 'select-tag'
                ]
            ])
            ->add('author',EntityType::class,[
                'label' => 'Sélectionner l\'autheur',
                'class' => User::class,
                'required' => false,
                'attr' => [
                    'class' => 'select-tag'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
