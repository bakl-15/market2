<?php

namespace App\Form;

use App\Entity\SellFlash;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SellFlashType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('endDate', DateType::class,[
                'attr' =>[
                    'placeholder' => 'Choisir la date'
                ]
            ])
            ->add('discount', NumberType::class,[
                'label' => 'Rabais *',
                 
                 
                'attr' => [
                    'placeholder' => 'entrer le pourcentage du rabais'
                     
                ]

            ])
            ->add('product', EntityType::class,[
                'label' => 'produit *',
                 'class' => Product::class,
                 'by_reference' => true,
                 
                'attr' => [
                    'class' => 'select-tag'
                     
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SellFlash::class,
        ]);
    }
}
