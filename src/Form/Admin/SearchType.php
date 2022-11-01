<?php

namespace App\Form\Admin;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class,[
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher ici...',
                    'class' => 'search-new',
                   
                ]
            ])
            ->add('category', EntityType::class,[
                'label' => 'Catégorie *',
                 'class' => Category::class,
                'attr' => [
                    'placeholder' => 'Catégories',
                    'class' => 'select-tag selectSerch',
                    'value' => 'CATEGORIE'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
