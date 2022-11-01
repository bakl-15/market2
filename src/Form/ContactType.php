<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ]
            ])
            ->add('email', TextType::class,[
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Entrer votre email'
                ]
            ])
            ->add('phone', TextType::class,[
                'label' => 'Votre numéro de teléphone',
                'attr' => [
                    'placeholder' => 'Entrer votre numéro de teléphone'
                ]
            ])
            ->add('subject', TextType::class,[
                'label' => 'Le sujet',
                'attr' => [
                    'placeholder' => 'Entrer le sujet'
                ]
            ])
            ->add('content',  CKEditorType::class,[
                'label' => 'Message',
                'attr' => [
                    'placeholder' => 'Entrer le contenu de votre méssage'
                ]
            ])
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
