<?php

namespace App\Form\Admin;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;


class AdminUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class,[
            'label' => 'Email *',
            'attr' => [
                'placeholder' => 'Entrer ton email'
            ]
          ])
          ->add('firstname', TextType::class,[
              'label' => 'Prénom *',
              'attr' => [
                  'placeholder' => 'Entrer ton prénom'
              ]
            ])
          ->add('lastname', TextType::class,[
              'label' => 'Nom *',
              'attr' => [
                  'placeholder' => 'Entrer ton nom'
              ]
            ])
          ->add('agreeTerms', CheckboxType::class, [
              'mapped' => false,
              'label' => 'Conditions génerales d\'utilisation *',
              'constraints' => [
                  new IsTrue([
                      'message' => 'You should agree to our terms.',
                  ]),
              ],
          ])
        
          ->add('plainPassword',  RepeatedType::class, [
              // instead of being set onto the object directly,
              // this is read and encoded in the controller
              'type' => PasswordType::class,
              'invalid_message' => 'Les mots de passe ne sont pas identiques.',
              'options' => ['attr' => ['class' => 'password-field']],
              'required' => true,
              'first_options'  => ['label' => 'Mot de passe *'],
              'second_options' => ['label' => 'Confirmer le mot de passe *'],
              'mapped' => false,
              'attr' => ['autocomplete' => 'new-password'],
              'constraints' => [
                  // new NotBlank([
                  //     'message' => 'Please enter a password',
                  // ]),
                  new Length([
                      'min' => 6,
                      'minMessage' => 'Your password should be at least {{ limit }} characters',
                      // max length allowed by Symfony for security reasons
                      'max' => 4096,
                  ]),
              ],
          ])
          ->add('image', FileType::class,[
            'label' => 'Photo de profile',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'choisir une photo',
                
            ],
            /**'constraints' => [
                new File([
                    'maxSize' => '10244k',
                    'mimeTypes' => [
                        'application/jpg',
                        'application/png',
                        'application/jpeg',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
                ])
            ],*/
          ])
          ->add('isVerified', CheckboxType::class,[
            'label' => 'L\'émail est verifié',
            'required' => false,
            'attr' => [
                'required' => false
            ]
          ])
          ->add('isAdmin',CheckboxType::class,[
            //  'type' => ChoiceType::class,
         
              'label' => 'Ajouter le role ADMINISTRATEUR',
              'required' => false,
              'mapped' => false,
              'attr' => [
                  'required' => false,
                  'checked' => false
              ]

              
             
           ],
            )
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
