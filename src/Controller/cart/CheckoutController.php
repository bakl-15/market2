<?php

namespace App\Controller\cart;

use App\Entity\Carrier;
use App\Form\CheckoutType;
use App\Service\CartService;
use App\Manager\OrderManager;
use App\Manager\CarrierManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    private $cartService;
    private $session;
    private $orderMnager;
    public function __construct(
        CartService $cartService,
        SessionInterface $session,
        OrderManager $orderMnager
        ){
         $this->cartService = $cartService;
         $this->session = $session;
         $this->orderMnager = $orderMnager;
    } 
    
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index( Request $request, CarrierManager $carrierManager): Response
    {
        $carriers = $carrierManager->getAllCarrier();
        $cart = $this->cartService->getFullCart();
        $user = $this->getUser();
        
        if( $this->session->get('checkout_data')){

            return $this->redirectToRoute('chekout_confirm');
        }
        if( ! $cart || ! $cart['products']){
            $this->addFlash('danger', 'Votre pannier est vide, veuillez rajouter des produits');
            return $this->redirectToRoute('product');
        }
         if( ! $user->getAddresses()->getValues()){
            $this->addFlash('warning', 'Merci d\'ajouter une addresse, avant de continuer !');
            return $this->redirectToRoute('address_new');
         }
         $form =  $this->createForm(CheckoutType::class,null,['user' => $user]);
          $form->handlerequest($request);
        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
            'carriers' =>$carriers
        ]);
        
    }
      /**
     * @Route("/checkout/confirm", name="checkout_confirm")
     */
    public function confirm(Request $request ): Response
    {
             
        $cart = $this->cartService->getFullCart();
        $user = $this->getUser();
        if(! $cart['products']){
            $this->addFlash('danger', 'Votre pannier est vide, veuillez rajouter des produits');
            return $this->redirectToRoute('product');
        }
         if( ! $user->getAddresses()->getValues()){
            $this->addFlash('warning', 'Merci d\'ajouter une addresse, avant de continuer !');
            return $this->redirectToRoute('address_new');
         }
         $form =  $this->createForm(CheckoutType::class,null,['user' => $user]);
         $form->handlerequest($request);
         if($form->isSubmitted() && $form->isValid() || $this->session->get('checkout_data')){
             if( $this->session->get('checkout_data')){
                 $data =  $this->session->get('checkout_data');
                 
             }else{
                $data = $form->getData();
                $this->session->set('checkout_data', $data);
             }
      
           $information = 'Pas de commentaire';
            $address  = $data['address'];
            $carrier  = $data['carrier'];
            if(isset($data['imformation'])){
                $information  = $data['imformation'];
            }
            $cart['checkout'] = $data;
             
           $reference = $this->orderMnager->saveCart($cart, $user);
   
            return $this->render('checkout/confirm.html.twig', [
                'cart' => $cart,
                'form' => $form->createView(),
                'carrier' => $carrier,
                'imformation' => $information,
                'adress' => $address,
                'reference' => $reference
            ]);
         }
         return $this->redirectToRoute('checkout');
    
    }
    /**
     * @Route("/checkout/edit", name="checkout_edit")
     */
    public function edit( Request $request, CarrierManager $carrierManager): Response
    {
        $this->session->set('checkout_data', []);
        return $this->redirectToRoute('checkout');
    }
}
