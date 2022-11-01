<?php

namespace App\Controller\cart;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @param CartService $cartService
     */
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(): Response
    {
        $cart = $this->cartService->getFullCart();
        if( !isset($cart['products'])){
         return  $this->redirectToRoute('home');
        }
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function addToCart($id): Response
    {
        $this->cartService->addToCart($id);
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/cart/delete/{id}", name="cart_delete")
     */
    public function deleteFromCart($id): Response
    {
        $this->cartService->deleteFromCart($id);
        return $this->redirectToRoute('cart_index');
    }
    /**
     * @Route("/cart/deleteall/{id}", name="cart_delete_all")
     */
    public function deleteAllFromCart($id): Response
    {
        $this->cartService->deleteAllFromCart($id);
        return $this->redirectToRoute('cart_index');
    }
}
