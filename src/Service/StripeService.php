<?php

namespace App\Service;

use Stripe\Stripe;
use App\Entity\Cart;
use Stripe\Checkout\Session;
use App\Manager\OrderManager;
use Doctrine\ORM\EntityManagerInterface;

class StripeService{
 
  
  private $orderManager;
  private $em;
  public function __construct(
  
   OrderManager $orderManager,
  EntityManagerInterface $em
   )
  {
     $this->em = $em;
     $this->orderManager = $orderManager;
  }

    public function getPayment($user, Cart $cart ){
      Stripe::setApiKey('sk_test_51JyIe0GMvscxMydyBQQtj0zx0ibWBp6rMhAmdWEXhyrDiAUMpQvjQX3q83BIOCqtsWp65j8diNzF9uYGLP6ld2Hm007bijHw9a');
    
 
     $order =  $this->orderManager->createOrder($cart);
      $checkout_session = Session::create([
        'customer_email' => $user->getEmail(),

        'line_items' => $this->orderManager->getLineItems($cart),
      
        'mode' => 'payment',
      
        'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-success/{CHECKOUT_SESSION_ID}',
      
        'cancel_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-cancel/{CHECKOUT_SESSION_ID}',
      
      ]);
      $order->setStripeSessionCheckoutID($checkout_session->id);
      $order->setStatus('Pending');
      $this->em->flush();
      return $checkout_session->id;
      }
    
}