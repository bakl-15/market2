<?php

namespace App\Form;

use App\Entity\HomeDecouver;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HomeDecouverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class,[
                'label' => 'Photo de la catégorie',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'choisir une photo',
                ],

            ])
            ->add('title', TextType::class,[
                'label' => 'L\'Entête partie droite*',
                'attr' => [
                    'placeholder' => 'Entrer Le titre...'
                ]
            ])
            ->add('content', CKEditorType::class,[
                'label' => 'L\'Entête partie droite*',
                'attr' => [
                    'placeholder' => 'Entrer le contenu ...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeDecouver::class,
        ]);
    }
}
