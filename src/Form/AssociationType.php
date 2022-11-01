<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('labele', TextType::class,[
                'label' => 'Lebelé*',
                'attr' => [
                    'placeholder' => 'Entrer Le libelé...'
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
