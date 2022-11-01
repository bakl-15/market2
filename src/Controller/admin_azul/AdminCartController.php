<?php

namespace App\Controller\admin_azul;

use App\Entity\Cart;
use App\Form\CartType;
use App\Manager\Manager;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/azul-admin/cart")
 */
class AdminCartController extends AbstractController
{
    /**
     * @Route("/", name="admin_cart_index", methods={"GET"})
     */
    public function index(CartRepository $cartRepository): Response
    {
        return $this->render('admin_azul/admin_cart/index.html.twig', [
            'carts' => $cartRepository->findAll(),
        ]);
    }

    
    /**
     * @Route("/{id}", name="admin_cart_show", methods={"GET"})
     */
    public function show(Cart $cart): Response
    {
        return $this->render('admin_azul/admin_cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_cart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cart $cart,  Manager $manager): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $data = [
            'type' => 'success',
            'message' => 'Le panier a été mis à jour avec succés !',
         
           ] ;
        $success =  $manager->newBySubmitForm($form,$cart,$request, $data);
        if($success){
         return $this->redirectToRoute('admin_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cart_delete", methods={"POST"})
     */
    public function delete(Request $request, Cart $cart, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
        
                $data = [
                    'type' => 'success',
                    'message' => 'Le panier  a été supprimé avec succés !'
                   ] ;
                $manager->remove($cart,$request,$data);
               
            }
    
        }

        return $this->redirectToRoute('admin_cart_index', [], Response::HTTP_SEE_OTHER);
    }
}
