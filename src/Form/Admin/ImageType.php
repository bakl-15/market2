<?php

namespace App\Form\Admin;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file',FileType::class, [
                'label' => 'Photo de produit',
                'mapped' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'choisir une photo',
                   
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'SVP charger le bon format d\'image',
                    ])
                ],
            ])
            ->add('caption', TextType::class,[
                'label' => 'le libelé de produit',
                'attr' => [
                    'placeholder' => 'Entrer la caption de l\'image',
                    'required' => false
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
