<?php

namespace App\Manager;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use App\Manager\Manager;
use App\Service\FileUploader;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Product as EntityProduct;
use Symfony\Component\HttpFoundation\Request;


class ProductManager extends Manager {
     
    private $repProduct;
    function __construct(
        EntityManagerInterface $em,
        FileUploader $fileUploader
        
    ) {
        parent::__construct($em,  $fileUploader);
         $this->repProduct = $this->em->getRepository(Product::class);
    }
    /*
        * @param Request $request
        * @param Form $form
        * @param $entity
        * @param Array $data
    **/
    public function newProductBySubmitForm( Form $form, Product $product,Request $request, $data): bool
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $images = $form->get('images')->getData();
         //  $categories = $form->get('category')->getData();
        
            foreach($images as $image){ 
               
                    $image->setProduct($product);
                    if($image->getFile()){
                            $filename =  $this->fileUploader->upload($image->getFile(), $data['directory']);
                            $image
                                ->setUrl($filename)
                                ;
                    }
              
            
         }
           
            $this->create($product);
            
            $request->getSession()->getFlashBag()->add(
                $data['type'],
                $data['message'],
  
            );
             return true;
        }else{
            return false;
        }
   }

   
    public function getProductIsBestSeller(){
        return $this->repProduct->findByIsBestSeller(1);
    }

    public function getProductIsEcolo(){
        return $this->repProduct->findByIsEcolo(1);
    }

    public function getProductIsNewArrival(){
        return $this->repProduct->findByIsNewArrival(1);
    }

    public function getProductIsFeatured(){
        return $this->repProduct->findByIsFeatured(1);
    }

    public function getProductIsSpecialOffer(){
        return $this->repProduct->findByIsSpecialOffer(1);
    }
    public function getProductIsNew(){
        return $this->repProduct->findByIsNew(1);
    }
    public function getProductIsSH(){
        return $this->repProduct->findByIsNew(0);
    }
    public function getProductBestNew(){
        return  $this->repProduct->getProductBestNew();
    }
    public function getProductBestSH(){
        return  $this->repProduct->findBy(
            ['isBestSeller' => '1'],
            ['isNew' => '0']
        );
    }
    public function getProductsNewNeuf(){
        return  $this->repProduct->findBy(
            ['isNew' => '1',
            'isNewArrival' => '1']
        );
    }
    public function getProductsNewOccasion(){
        return  $this->repProduct->findBy(
            ['isNew' => '0',
            'isNewArrival' => '1']
        );
    }
    public function getProductsNewEcolo(){
        return  $this->repProduct->findBy(
            ['isEcolo' => '1',
            'isNewArrival' => '1']
        );
    }
    public function getDataProduct(){
        $data = [
            'isBestSeller' => $this->getProductIsBestSeller(),
            'isNewArrival' => $this->getProductIsNewArrival(),
            'isEcolo'      => $this->getProductIsEcolo(),
            'isFeatured'   => $this->getProductIsFeatured(),
            'isSpecialOffer'=> $this->getProductIsSpecialOffer()
        ];
        return $data;
    }

    public function getAllProducts(){
        return $this->repProduct->findAll();
    }

    public function getProductByCategory(Product $mainProduct){
        $categories = $mainProduct->getCategory();
        $products = [];
         foreach($categories as $category){
              foreach($category->getProducts() as $product){
                $products[] =  $product;
              }
             
         }
         return $products;
    }

  public function getProductURL(string $name){
    $product =  $this->repProduct->findOneByName($name);
    if(count($product->getImages() )>0){
       foreach($product->getImages() as $key => $image){
        if($key === 0){
            $imageUrl = $image->getUrl();
            return $imageUrl;
        }
       
       
       }
    }else{
        return "";
    }
    
   
   }

   public function getProductCategory(Category $category){
      $products =  $this->repProduct->findByCategory($category);
      return $products;
   }
/**
 * Undocumented function
 *
 * @return Product[]
 */
   public function findBySearch($searchProduct): array
   {
     $rep = $this->em->getRepository(Product::class);

      return $rep->getProductsByFiltre($searchProduct);
   }

  public function getMinMax($searchProduct){
    $rep = $this->em->getRepository(Product::class);
    return $rep->getMinMax($searchProduct);
   }
}