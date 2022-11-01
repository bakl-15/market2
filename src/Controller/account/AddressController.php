<?php

namespace App\Controller\account;

use App\Entity\Address;
use App\Form\AddressType;
use App\Service\CartService;
use App\Manager\AddressManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/address")
 */
class AddressController extends AbstractController
{
    /**
     * @var AddressManager
     */
    private $addressManager;
     /**
     * @var Session
     */
    private $session;
    /**
     * @param AddressManager $addressManager
     */
     public function __construct(AddressManager $addressManager, SessionInterface $session){
        $this->session = $session;
        $this->addressManager = $addressManager;
     }
    /**
     * @Route("/", name="address_index", methods={"GET"})
     */
    public function index(): Response
    {  $user = $this->getUser();
        return $this->render('account/address/index.html.twig', [
            'addresses' => $this->addressManager->getAddressesByUser($user),
        ]);
    }

    /**
     * @Route("/new", name="address_new", methods={"GET","POST"})
     */
    public function new(Request $request, CartService $cartService): Response
    {
        $address = new Address();
        $address->setUser($this->getUser());
        $form = $this->createForm(AddressType::class, $address);
        $data = [
                 'type' => 'success',
                 'message' => 'Votre adresse  a été crée avec succés !'
                ] ;

       $success =  $this->addressManager->newBySubmitForm($form,$address,$request, $data);
       if($success){
           if($cartService->getFullCart()){
            return $this->redirectToRoute('checkout');
           }
  
          return $this->redirectToRoute('address_index');
       }
      
        return $this->renderForm('account/address/new.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="address_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Address $address): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $data = [
            'type' => 'success',
            'message' => 'Votre adresse ( ' . $address->getFullname() . ' ) a été mis à jour avec succés !'
           ] ;
        $success =  $this->addressManager->newBySubmitForm($form,$address,$request, $data);
        if($success){
                if($this->session->get('checkout_data')){
                    $dataConfirm = $this->session->get('checkout_data');
                    $dataConfirm['address'] = $address;
                   
                    $this->session->set('checkout_data',  $dataConfirm);
                 
                    return $this->redirectToRoute('checkout_confirm', [], Response::HTTP_SEE_OTHER);
                }
         return $this->redirectToRoute('address_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('account/address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="address_delete", methods={"POST"})
     */
    public function delete(Request $request, Address $address): Response
    { 
        $data = [
            'type' => 'success',
            'message' => 'Votre adresse ( ' . $address->getFullname() . ' ) a été  supprimé avec succés !'
           ] ;
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
           
            $this->addressManager->remove($address,$request, $data);
        }

        return $this->redirectToRoute('address_index', [], Response::HTTP_SEE_OTHER);
    }
}
