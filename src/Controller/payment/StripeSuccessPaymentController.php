<?php

namespace App\Controller\payment;

use App\Entity\Order;
use App\Service\CartService;
use App\Service\StockService;
use App\Service\EmailSenderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeSuccessPaymentController extends AbstractController
{
    /**
     * @Route("/stripe-payment-success/{stripeSessionCheckoutID}", name="stripe-payment-success")
     */
    public function index(
        ?Order $order,
        CartService $cartService,
        EntityManagerInterface $em,
        StockService $st,
        EmailSenderService $ess
         ): Response
    {
         $user = $this->getUser();
         
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('home');
           
        }
        if(!$order->getIsPaid()){
            $data = [
                'title' => 'Votre commande a été validé avec succés',
                'content' =>' Le contenu de l\'email de confirmation '
            ];
           $order->setIsPaid(true);
           $order->setStatus('En cours de préparation');
           $st->desTock($order);
           $em->flush();
           $cartService->deleteCart();
            $ess->send(
                    $user->getEmail(),
                    $user->fullname(),
                    'Votre commande a été validé avec succés',
                    $data
            );
            

        } 
        return $this->render('payment/stripe_success_payment/index.html.twig', [
            'order' => $order,
        ]);
    }
}
