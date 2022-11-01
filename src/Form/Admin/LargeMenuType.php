<?php

namespace App\Form\Admin;

use App\Entity\NavLarge;
use App\Entity\CategoryParent;
use App\Manager\CategoryManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LargeMenuType extends AbstractType
{
    private $categoryManager;
    private $em;
    public function __construct(CategoryManager $categoryManager, EntityManagerInterface $em){
       $this->categoryManager = $categoryManager;
       $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom de la catégorie *',
                'attr' => [
                    'placeholder' => 'Entrer le nom de la nouvelle catégorie'
                ]
            ])
            ->add('CatParente', EntityType::class,[
                'label' => $this->label($options),
                 'class' => CategoryParent::class,
                 'by_reference' => false,
                 'multiple' => true,
                'attr' => [
                    'class' => 'select-tag'
                ],
               
                'choices' =>[
                    $this->label($options) => $this->isNew($options),
                ] 
               
            ])

            ->add('image', FileType::class,[
                'label' => 'Photo du menu',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'choisir une photo',
                   
                ],
           
            ]) 
            ->add('ribbon',TextType::class,[
                'label' => 'Nom du ribbon *',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrer du ribbon'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NavLarge::class,
            'isNew' => null
         
        ]);
    }
    private function isNew($options){
        $isNew = null;
        if($options['isNew'] === 'old'){
             $isNew = $this->categoryManager->getCategoriesOldProducts();
        }
        elseif($options['isNew'] === 'new'){
            $isNew =  $this->categoryManager->getCategoriesNewProducts();
       }elseif($options['isNew'] === 'other'){
        $isNew = $this->em->getRepository(CategoryParent::class)->findAll();
       }
       return $isNew ;
    }
    private function label($options){
        $isNew = null;
        if($options['isNew'] === 'old'){
             $isNew =  'Catégorie parrente (occasion) *';
        }
        elseif($options['isNew'] === 'new'){
            $isNew =  'Catégorie parrente (neuf) *';
       }else{
        $isNew = 'Catégorie parrente *';
       }
       return $isNew ;
    }
}
