<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname',TextType::class,[
                'label' => 'Nom *',
                 'attr' => [
                     'placeholder' => 'Entrer ton nom'
                 ]
            ])
            ->add('company', textType::class,[
                'label' => 'Entreprise *',
                'attr' => [
                    'placeholder' => 'Entrer ton entreprise'
                ]
            ])
            ->add('address', TextareaType::class,[
                'label' => 'Rue *',
                'attr' => [
                    'placeholder' => 'Entrer la rue'
                ]
            ])
            ->add('complement',TextareaType::class,[
                'label' => 'Complement d\'adresse',
                'attr' => [
                    'placeholder' => 'Entrer un complement d\'adresse'
                ]
            ])
            ->add('phone', TextType::class,[
                'label' => 'Numéro de télephone *',
                'attr' => [
                    'placeholder' => 'Entrer ton numéro de télephone'
                ]
            ])
            ->add('city',TextType::class,[
                'label' => 'La ville *',
                'attr' => [
                    'placeholder' => 'Entrer ta ville'
                ]
            ])
            ->add('zipCode', TextType::class,[
                'label' => 'Addresse postale *',
                'attr' => [
                    'placeholder' => 'Entrer l\'adresse postale'
                ]
            ])
            ->add('country', CountryType::class,[
                'label' => 'Pays *',
                'attr' => [
                    'placeholder' => 'Entrer ton pays',
                    'class' => 'form-control'
                ]
            ])
       
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
