<?php
/**
 * Coded by BAAKEL Sofiane
 */

namespace   App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{ 
    /**
     * @var float $tva
     */
     private $tva = 0.1;

    /**
     * @var SessionInterface $session
     */
    private $session;
      /**
     * @var ProductRepository $session
     */
    private $repProduct;
    public function __construct(
         SessionInterface $session, 
         ProductRepository $repProduct
         )
    { 
        $this->session = $session;
        $this->repProduct = $repProduct;
    }

  /**
   * Ajouter un prodit au panier 
   * @param int $id
   */
    public function addToCart($id){
        $cart = $this->getCart();
   
        if(isset($cart[$id])){
            $cart[$id]++;
        }else{
           $cart[$id] = 1;
        }
        $this->updateCart($cart);

    }
    /**
     * Supprimer une quantité d' un produit de panier
     * @param int $id
     */
    public function deleteFromCart($id){
          $cart = $this->getCart();
          if(isset($cart[$id])){
              if($cart[$id]  > 1 ){
                $cart[$id] --;
              }else{
                  unset($cart[$id]);
              }
              $this->updateCart($cart);
          }
    }
    /**
     * supprimer un produit de pannier
     * @param int $id
     */
    public function deleteAllFromCart($id){
        $cart = $this->getCart();
        if(isset($cart[$id])){  
             unset($cart[$id]);
             $this->updateCart($cart);
        }
    }

    /**
     * clear le panier
     */
    public function deleteCart(){
        $this->updateCart([]);
    }

   /**
    * Mettre à jour le panier
    *  @param  array $cart
    */
    public function updateCart($cart){
      $this->session->set('cart',$cart);
      $this->session->set('cartData', $this->getFullCart());
    }

    public function getCart(){
       return $this->session->get('cart',[]);
    }
        /**
         * Obtenir tous les produits stocker dans le panier
         *@return array 
        */

    public function getFullCart(): array
    {
        $cart = $this->getCart();
        $subtotal = 0;
        $quantity_cart = 0;
        $data_cart = [];
        $isNull = false;
        foreach( $cart as $id => $quantity ){
            $product = $this->repProduct->findOneById($id);    
            if($product){
                //gestion des stock
                if($quantity > $product->getQuantity()){
                    $quantity = $product->getQuantity();
                    $cart[$id] =$quantity;
                    $this->updateCart($cart);
                }

                //----------------
              $data_cart['products'][] = [
                  'quantity' => $quantity,
                  'product' => $product,
                  'images' => $product->getImages(),
                  'subtotal' => round($quantity * $product->getPrice(),2)
              ];
              $quantity_cart +=  $quantity;
              $subtotal +=  round($quantity * $product->getPrice(),2);
              $isNull = true;
            }else{
                $this->deleteAllFromCart($id);
              
            }
        }
         
        if( $isNull === true){
            $data_cart['data_cart'] = [
                'quantity_cart' => $quantity_cart,
                'amountHT' => round($subtotal,2),
                'taxe' => round(($subtotal * $this->tva),2) ,
                'amountTTC' => round(($subtotal + ($subtotal * $this->tva)),2)
             ];
        }else{
            $data_cart = [];
        }
         
        
        return $data_cart;
    }
}