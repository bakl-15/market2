<?php

namespace App\Form\Admin;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom de la catégorie *',
                'attr' => [
                    'placeholder' => 'Entrer le nom de la nouvelle catégorie'
                ]
            ])
            ->add('ribbon',TextType::class,[
                'label' => 'Nom du ribbon *',
                'attr' => [
                    'placeholder' => 'Entrer du ribbon'
                ]
            ])
            ->add('description',TextareaType::class,[
                'label' => 'Déscription *',
                'attr' => [
                    'placeholder' => 'Veuillez rajouter  une bréve déscription à la catégorie '
                ]
            ])
            ->add('image', FileType::class,[
                'label' => 'Photo de la catégorie',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'choisir une photo',
                   
                ],
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '1024k',
                //         'mimeTypes' => [
                //             'image/jpg',
                //             'image/png',
                //             'image/jpeg',
                //         ],
                //         'mimeTypesMessage' => 'SVP charger le bon format d\'image',
                //     ])
                // ],
            ])
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
