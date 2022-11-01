<?php

namespace App\Form;

use App\Entity\Category;
use App\Data\SearchProduct;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class,[
                'label' => false,
                'required' => false,
                 'attr' => [
                     'placeholder' => 'Rechercher'
                 ]
            ])
            ->add('categories',EntityType::class,[
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                 'attr' => [
                     'placeholder' => 'Rechercher'
                 ]
            ])
            ->add('maxPrice', IntegerType::class,[
                'label' => false,
                'required' => false,
                 'attr' => [
                     'placeholder' => 'min'
                 ]
            ])
            ->add('minPrice', IntegerType::class,[
                'label' => false,
                'required' => false,
                 'attr' => [
                     'placeholder' => 'max'
                 ]
            ])
            ->add('promo', CheckboxType::class,[
                'label' => "En promotion",
                'required' => false,
             
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' =>   SearchProduct::class,
            'method' => 'GET'
        ]);
    }
     public function getBlockPrefix()
     {
         return '';
     }
}
