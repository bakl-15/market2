<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
     
        $user = $options['user'];
        $builder
            ->add('address', EntityType::class,[
                'label' => 'Sélectionner l\'addresse de la livraison',
                'class' => Address::class,
                'required' => true,
                'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true,
              
            ])
            ->add('carrier', EntityType::class,[
              
                'class' => Carrier::class,
                'required' => true,
                'multiple' => false,
                'expanded' => true,
              
            ])
            ->add('imformation',TextareaType::class,[
                'label' => 'Laissez un commentaire ! ',
                 'required' => false,
                 'attr' => [
                    'placeholder' => 'Plus d\'informations'
                     ]
            ])
        ; 
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user' => User::class
        ]);
    }
}
