<?php

namespace App\Form\Admin;

use App\Entity\HomeSlider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class HomeSliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Le titre de slider *',
                'attr' => [
                    'placeholder' => 'Entrer le titre de slider'
                ]
            ])
            ->add('headerLeft',TextType::class,[
                'label' => 'L\'Entête partie gauche*',
                'attr' => [
                    'placeholder' => 'Entrer L\'Entête partie gauche'
                ]
            ])
            ->add('headerRight', TextType::class,[
                'label' => 'L\'Entête partie droite*',
                'attr' => [
                    'placeholder' => 'Entrer L\'Entête partie droite...'
                ]
            ])
            ->add('description', TextType::class,[
                'label' => 'Description*',
                'attr' => [
                    'placeholder' => 'Entrer une description...'
                ]
            ])
            ->add('buttonMessage', TextType::class,[
                'label' => 'Le message du bouton*',
                'attr' => [
                    'placeholder' => 'Entrer le message du bouton...'
                ]
            ])
            ->add('buttonUrl', TextType::class,[
                'label' => 'Le lien du bouton*',
                'attr' => [
                    'placeholder' => 'Entrer le lien du bouton...'
                ]
            ])
            ->add('image', FileType::class,[
                'label' => 'Photo de la catégorie',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'choisir une photo',
                ],

            ])
            ->add('isDisplayed', CheckboxType::class,[
                'label' => 'Affiché *',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeSlider::class,
        ]);
    }
}
