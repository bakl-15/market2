<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class StockService{

    private $em;   
    private $repProduct;

    public function __construct(
        EntityManagerInterface $em
    ){
        $this->em = $em;
        $this->repProduct = $em->getRepository(Product::class);
    }
    
    public function desTock(Order $order){
        $orderDetails = $order->getOrderDetails()->getValues();
         foreach( $orderDetails as $key => $details){
             $product = $this->repProduct->findByName($details->getProductName())[0];
             $newQuantity = $product->getQuantity() - $details->getQuantity();
             $product->setQuantity($newQuantity);
             $this->em->flush();

            }
    }
}

