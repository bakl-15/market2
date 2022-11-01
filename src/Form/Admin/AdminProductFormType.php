<?php

namespace App\Form\Admin;

use App\Entity\Tags;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Coupon;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\BooleanType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom de produit *',
                'attr' => [
                    'placeholder' => 'Entrer le nom de nouveau produit'
                ]
            ])
            ->add('description', CKEditorType::class,[
                'label' => 'Déscription *',
                'attr' => [
                    'placeholder' => 'Veuillez rajouter  une bréve déscription au produit  '
                ]
            ])
            ->add('moreInformations', CKEditorType::class,[
                'label' => 'Plus d\'information',
                'attr' => [
                    'placeholder' => 'Vous pouvez rajouter des imformations supplementaires . '
                ]
            ])
            ->add('price',MoneyType::class,[
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Entrer  le prix deproduit. '
                ]
            ])
            ->add('quantity',NumberType::class,[
                'label' => 'Quantité',
                'attr' => [
                    'placeholder' => 'Entrer  la quantité. '
                ]
            ])
            ->add('isBestSeller', CheckboxType::class,[
                'label' => 'Meuilleur vente',
                'required'   => false,
                'attr' => [
                    'placeholder' => 'Entrer  le prix deproduit. '
                ]
            ])
            ->add('isNewArrival', CheckboxType::class,[
                'label' => 'Nouveau',
                'required'   => false,
            ])
            ->add('isEcolo', CheckboxType::class,[
                'label' => 'Ecologique',
                'required'   => false,
            ])
            ->add('isFeatured', CheckboxType::class,[
                'label' => 'Populaire',
                'required'   => false,
            ])
            ->add('isSpecialOffer', CheckboxType::class,[
                'label' => 'Offre spécial',
                'required'   => false,
            ])
            ->add('isNew', CheckboxType::class,[
                'label' => 'Produit neuf',
                'required'   => false,
                'attr' =>[
                    'name' => 'stat',
                    'checked' => 'checked'
                ]
            ])

          
            ->add('category', EntityType::class,[
                'label' => 'Catégorie *',
                 'class' => Category::class,
                 'by_reference' => false,
                 'multiple' => true,
                'attr' => [
                    'class' => 'select-tag'
                     
                ]

            ])
            ->add('images',
             CollectionType::class,
             [
                 'entry_type' => ImageType::class,
                 'allow_add' => true
             ])
             ->add('tags', EntityType::class,[
                'label' => 'Ribbon *',
                 'class' => Tags::class,
                 'by_reference' => false,
                 'multiple' => true,
                'attr' => [
                    'class' => 'select-tag'
                     
                ]

            ])
            ->add('coupon', EntityType::class,[
                'label' => 'Coupon',
                 'class' => Coupon::class,
                 'by_reference' => false,
                 'multiple' => true,
                'attr' => [
                    'class' => 'select-tag'
                     
                ]

            ])
        ;
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
