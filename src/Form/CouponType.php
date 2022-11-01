<?php

namespace App\Form;

use App\Entity\Coupon;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CouponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',TextType::class,[
                'label' => 'Le coupon',
                'attr' =>[
                    'placeholder' => 'Entrer le coupon'
                ]
            ])
            ->add('type', ChoiceType::class,[
                'label' => 'Le décompte',
                'choices' => [
                    'Pourcentage' => 'Pourcentage',
                    'Montant fixe' => 'Montant fixe',
                ],
                'attr' =>[
                    'placeholder' => 'Choisir le type'
                ]
            ])
            ->add('discount', NumberType::class,[
                'label' => 'Le décompte',
                'attr' =>[
                    'placeholder' => 'Entrer le décompte'
                ]
            ])
            ->add('status',ChoiceType::class,[
                'label' => 'Le status',
                'choices' => [
                    'Activé' => 'Activé',
                    'Désactivé' => 'Désactivé',
                ],
                'attr' =>[
                    'placeholder' => 'Choisir le status du coupon'
                ]
            ])
            ->add('products', EntityType::class,[
                'label' => 'produit *',
                 'class' => Product::class,
                 'by_reference' => false,
                 'multiple' => true,
                'attr' => [
                    'class' => 'select-tag'
                     
                ]

            ])
        
         
            ->add('endDate', DateType::class,[
                'attr' =>[
                    'placeholder' => 'Choisir la date'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coupon::class,
        ]);
    }
}
