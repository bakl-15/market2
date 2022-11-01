<?php

namespace App\Controller\payment;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeCancelPaymentController extends AbstractController
{
    /**
     * @Route("/stripe-payment-cancel/{stripeSessionCheckoutID}", name="stripe-payment-cancel")
     */
    public function index(Order $order, EntityManagerInterface $em): Response
    {
        if(!$order || $order->getUser() !== $this->getUser()){
            return $this->redirectToRoute('home');
           
        }
        $order->setStatus('Annulé');
        $order->setIsPaid(false);
        $em->flush();
        return $this->render('payment/stripe_cancel_payment/index.html.twig', [
            'order' => $order,
        ]);
    }
}
