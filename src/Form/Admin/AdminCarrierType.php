<?php

namespace App\Form\Admin;

use App\Entity\User;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class AdminCarrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom *',
                'attr' => [
                    'placeholder' => 'Entrer le nom de transporteur'
                ]
              ])
            ->add('description', CKEditorType::class,[
                'label' => 'Plus d\'information',
                'attr' => [
                    'placeholder' => 'Vous pouvez rajouter une description . '
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => ' prix ',
                'attr' => [
                    'placeholder' => 'Entrer le prix de transporteur . '
                ]
                ])
             
          ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carrier::class,
        ]);
    }
}
