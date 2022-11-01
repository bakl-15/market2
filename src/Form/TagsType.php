<?php

namespace App\Form;

use App\Entity\Tags;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'labelé *',
                'attr' => [
                  'placeholder' => ' entrer le labelé'
                ]
            ])
            
            
            ->add('product', EntityType::class,[
                'label' => 'produit *',
                 'class' => Product::class,
                 'by_reference' => false,
                 'multiple' => true,
                'attr' => [
                    'class' => 'select-tag'
                     
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tags::class,
        ]);
    }
}
