<?php

namespace App\Form\Admin;

use App\Entity\Contact;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrer le nom '
                ]
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrer l\'email '
                ]
            ])
            ->add('phone',TextType::class,[
                'label' => 'Numéro de télephone',
                'attr' => [
                    'placeholder' => 'Entrer le numéro de télephone '
                ]
            ]  )
            ->add('subject',TextType::class,[
                'label' => 'Sujet',
                'attr' => [
                    'placeholder' => 'Entrer le sujet '
                ]
            ])
            ->add('content', CKEditorType::class,[
                'label' => 'Message',
               
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
