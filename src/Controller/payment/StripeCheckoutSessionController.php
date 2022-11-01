<?php

namespace App\Controller\payment;

use Stripe\Stripe;
use App\Entity\Cart;
use App\Service\CartService;
use Stripe\Checkout\Session;
use App\Manager\OrderManager;
use App\Service\StripeService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeCheckoutSessionController extends AbstractController
{

     private $stripeService;
     public function __construct(StripeService $stripeService)
     {
       $this->stripeService = $stripeService;
     }
    /**
     * @Route("/create-checkout-session/{reference}", name="payment_stripe_checkout_session")
     */
    public function index(?Cart $cart): Response
    {
      $user = $this->getUser();
      if(!$cart){
         return $this->redirectToRoute('home');
      }
     
     $checkout_session_id =   $this->stripeService->getPayment($user,$cart);
   
      
      return $this->json(['id' => $checkout_session_id]);
    }
}
