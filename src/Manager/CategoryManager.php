<?php

namespace App\Manager;
use App\Entity\Product;
use App\Entity\Category;
use App\Manager\Manager;
use App\Service\FileUploader;
use App\Entity\CategoryParent;
use App\Manager\ProductManager;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;



class CategoryManager extends Manager {


    private $repProduct;
    function __construct(
        EntityManagerInterface $em,
        FileUploader $fileUploader
        
    ) {
        parent::__construct($em,  $fileUploader);
         $this->repProduct = $this->em->getRepository(Product::class);
    }
    /**
     * permit de recuperer toutes les catégories
     */
    public function getAllCategories(){
        $rep = $this->em->getRepository(Category::class);
        return $rep->findAll();
    }

    /*
        * @param Request $request
        * @param Form $form
        * @param $entity
        * @param Array $data
    **/
  public function newCategoryBySubmitForm( Form $form, $category,Request $request, $data): bool
  {
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
       
        if($form->get('image')->getData()){
          
               if($category->getImage()) {
                unlink( $data['directory'] . '/' . $category->getImage());
               }
           
            $image = $form->get('image')->getData();
            $image =  $this->fileUploader->upload($image, $data['directory']);
            $category->setImage($image);
      
        }
          $this->save($category);
          
          $request->getSession()->getFlashBag()->add(
              $data['type'],
              $data['message'],

          );
           return true;
      }else{
          return false;
      }
 }

   
    public function getCategoriesOldProducts(){
      
        $oldProducts = $this->repProduct->findByIsNew(0);
        $categories = [];
        $cats = [];
        $categoryParent = [];
        foreach($oldProducts as $product){
            foreach( $product->getCategory() as $category){
                $categories[] = $category;
            }
        }
   $cats = array_unique($categories);
        foreach($cats as $c){
            foreach($c->getCategoryParents() as $cp ){
                $categoryParent[] = $cp;
            }
        }
      return array_unique($categoryParent)  ;
    }
    public function getCategoriesNewProducts(){
      
        $oldProducts = $this->repProduct->findByIsNew(1);
        $categories = [];
        $cats = [];
        $categoryParent = [];
        foreach($oldProducts as $product){
            foreach( $product->getCategory() as $category){
                $categories[] = $category;
            }
        }
   $cats = array_unique($categories);
        foreach($cats as $c){
            foreach($c->getCategoryParents() as $cp ){
                $categoryParent[] = $cp;
            }
        }
      return array_unique($categoryParent)  ;
    }
}