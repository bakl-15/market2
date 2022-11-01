<?php

namespace App\Form;

use App\Entity\Order;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class,[
                'label' => 'Reférence de la commande',
                'attr' => [
                    'placeholder' => 'Entrer une réference pour la commande en cours'
                ]
            ])
            ->add('fullname', TextType::class,[
                'label' => 'Le client',
                'attr' => [
                    'placeholder' => 'Entrer le client de la commande en cours'
                ]
            ])
            ->add('carrierName', TextType::class,[
                'label' => 'Livreur',
                'attr' => [
                    'placeholder' => 'Entrer le nom de livreur'
                ]
            ])
            ->add('carrierPrice', MoneyType::class, [
                'label' => 'Le prix de la livraison',
                'attr' => [
                    'placeholder' => 'Entrer le prix de la livraison'
                ]
            ])
            ->add('delevryAddress',TextareaType::class, [
                'label' => 'L\addresse de la livraison',
                'attr' => [
                    'placeholder' => 'Entrer la bonne addresse de la livraison'
                ]
            ])
            ->add('isPaid', CheckboxType::class,[
                'required' => false,
                'label' => 'La commande est il payé',
            ])
            ->add('moreInformation', CKEditorType::class,[
                'label' => 'Détail informative de la commande',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrer les Détails informatives de la commande'
                ]
            ])
        
            ->add('quantity', NumberType::class,[
                'label' => 'La quantité de la commande',
                'attr' => [
                    'placeholder' => 'Entrer la quantité de la commande'
                ]
            ])
            ->add('subTotalHT' , MoneyType::class,[
                'label' => 'Le montant en HT de la commande',
                'attr' => [
                    'placeholder' => 'Entrer le montant en HT  de la commande'
                ]
            ])
            ->add('taxe', MoneyType::class,[
                'label' => 'La taxe de la commande',
                'attr' => [
                    'placeholder' => 'Entrer la taxe de la commande'
                ]
            ])
            ->add('subTotalTTC', MoneyType::class,[
                'label' => 'Le montant TTC de la commande',
                'attr' => [
                    'placeholder' => 'Entrer Le montant TTC de de la commande'
                ]
            ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
