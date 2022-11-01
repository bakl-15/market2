<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CommentType extends AbstractType
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
                    'class' => 'radio'
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
                    'class' => 'radio'
                ]
            ])
            ->add('content', CKEditorType::class,[
                'label' => 'Votre commentaire'
            ])
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
          
        ]);
    }
}
