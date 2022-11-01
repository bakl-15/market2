<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class SearchService{
   
    private $em;
     public function __construct(EntityManagerInterface $em){
           $this->em = $em;
     }
    public function getProductsBySearch(array $data){
        $rep = $this->em->getRepository(Product::class);
         return   $rep->getProductsBySearch($data);

    }
}

