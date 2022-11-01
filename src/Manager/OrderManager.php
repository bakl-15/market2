<?php
namespace App\Manager;

use App\Entity\Cart;
use App\Entity\Order;
use App\Manager\Manager;
use App\Entity\CartDetail;
use App\Entity\OrderDetail;
use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;



class OrderManager extends Manager{

    private $manager;
    private $repoProduct;
    private $productManager;
    private $address ;

    public function __construct(
      EntityManagerInterface $manager, 
      ProductRepository $repoProduct,
      ProductManager $productManager
      )
    {
        $this->manager = $manager;
        $this->repoProduct = $repoProduct;
        $this->productManager = $productManager;
    }

    public function createOrder($cart){

        $order = new Order();
        $order->setReference($cart->getReference())
              ->setCarrierName($cart->getCarrierName())
              ->setCarrierPrice($cart->getCarrierPrice()/100)
              ->setFullName($cart->getFullName())
              ->setDelevryCity($cart->getDelevryCity())
              ->setDelevryCountry($cart->getDelevryCountry())
              ->setDelevryZipCode($cart->getDelevryZipCode())
              ->setDelevryCompany($cart->getDelevryCompany())
              ->setDelevryPhone($cart->getDelevryPhone())
              ->setDelevryAddress($cart->getDelevryAddress())
              ->setMoreInformation($cart->getMoreInformation())
              ->setQuantity($cart->getQuantity())
              ->setSubtotalHT($cart->getSubTotalHT()/100)
              ->setTaxe($cart->getTaxe()/100)
              ->setSubtotalTTC($cart->getSubTotalTTC()/100)
              ->setUser($cart->getUser())
              ->setCreatedAt($cart->getCreatedAt());
        $this->manager->persist($order);

        $products = $cart->getCartDetails()->getValues();

        foreach ($products as $cart_product) {
          
            $orderDetails = new OrderDetail();
            $orderDetails->setOrders($order)
                         ->setProductUrl($this->productManager->getProductURL($cart_product->getProductName()))
                         ->setProductName($cart_product->getProductName())
                         ->setProductPrice($cart_product->getProductPrice())
                         ->setQuantity($cart_product->getQuantity())
                         ->setSubTotalHT($cart_product->getSubTotalHT())
                         ->setSubTotalTTC($cart_product->getSubTotalTTC())
                         ->setTaxe($cart_product->getTaxe());
            $this->manager->persist($orderDetails);
        }

        $this->manager->flush();

        return $order;
    }
    public function getLineItems($cart){
        $cartDetails = $cart->getCartDetails();

        $line_items = [];
        foreach ($cartDetails as $details) {
            $product = $this->repoProduct->findOneByName($details->getProductName());

            $line_items[] = [
                'price_data' => [
                  'currency' => 'eur',
                  'unit_amount' => $product->getPrice() * 100,
                  'product_data' => [
                    'name' => $product->getName(),
                    'images' => [$_ENV['YOUR_DOMAIN'].'/uploads/images/'.$product->getMainImage()],
                  ],
                ],
                'quantity' =>  $details->getQuantity(),
            ];
        }

        // Carrier
        $line_items[] = [
            'price_data' => [
              'currency' => 'eur',
              'unit_amount' => $cart->getCarrierPrice() * 100,
              'product_data' => [
                'name' => 'Livraison ( '.$cart->getCarrierName().' )',
                'images' => [$_ENV['YOUR_DOMAIN'].'/uploads/products/'],
              ],
            ],
            'quantity' =>  1,
        ];

        // Taxe
        $line_items[] = [
            'price_data' => [
              'currency' => 'eur',
              'unit_amount' => $cart->getTaxe(),
              'product_data' => [
                'name' => 'TVA (20%)',
                'images' => [$_ENV['YOUR_DOMAIN'].'/uploads/products/'],
              ],
            ],
            'quantity' =>  1,
        ];
        

        return $line_items;
    }
    
    public function saveCart($data, $user){
      
        $cart = new Cart();
        $reference = $this->generateUuid();
        $address = $data['checkout']['address'];
       
        $carrier = $data['checkout']['carrier'];
        $informations = $data['checkout']['imformation'];
         $this->address = $address;
        $cart->setReference($reference)
             ->setCarrierName($carrier->getName())
             ->setCarrierPrice($carrier->getPrice()/100)
             ->setFullName($address->getFullName())
             ->setDelevryCity($address->getCity())
             ->setDelevryCountry($address->getCountry())
             ->setDelevryZipCode($address->getZipCode())
             ->setDelevryCompany($address->getCompany())
             ->setDelevryPhone($address->getPhone())
             ->setDelevryAddress($address)
             ->setMoreInformation($informations)
             ->setQuantity($data['data_cart']['quantity_cart'])
             ->setsubTotalHT(($data['data_cart']['amountHT']))
             ->setTaxe($data['data_cart']['taxe'])
              ->setSubtotalTTC(round(($data['data_cart']['amountTTC']+$carrier->getPrice()/100),2))
              ->setUser($user)
              ->setCreatedAt(new \DateTime());
        $this->manager->persist($cart);

        $cart_details_array = [];

        foreach ($data['products'] as $products) {
            $cartDetails = new CartDetail();
            
            $subtotal = $products['quantity'] * $products['product']->getPrice()/100;

            $cartDetails->setCarts($cart)
                         ->setProductName($products['product']->getName())
                         ->setProductPrice($products['product']->getPrice()/100)
                         ->setQuantity($products['quantity'])
                         ->setSubTotalHT($subtotal)
                         ->setSubTotalTTC($subtotal*1.2)
                         ->setTaxe($subtotal*0.2);
            $this->manager->persist($cartDetails);
            $cart_details_array[] = $cartDetails;
        }

        $this->manager->flush();

        return $reference;

    }

    public function generateUuid(){
        
        // Initialise le générateur de nombres aléatoires Mersenne Twister
        mt_srand((double)microtime()*100000);

        //strtoupper : Renvoie une chaîne en majuscules
        //uniqid : Génère un identifiant unique
        $charid = strtoupper(md5(uniqid(rand(), true)));

        //Générer une chaîne d'un octet à partir d'un nombre
        $hyphen = chr(45);

        //substr : Retourne un segment de chaîne
        $uuid = ""
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid, 12, 4).$hyphen
        .substr($charid, 16, 4).$hyphen
        .substr($charid, 20, 12);
        
        return $uuid;

    }

    
}