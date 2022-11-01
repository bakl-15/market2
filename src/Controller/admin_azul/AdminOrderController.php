<?php

namespace App\Controller\admin_azul;

use App\Entity\Order;
use App\Entity\Carrier;
use App\Form\OrderType;
use App\Manager\Manager;
use App\Manager\OrderManager;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/order")
 */
class AdminOrderController extends AbstractController
{

   
    /**
     * @Route("/", name="admin_order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('admin_azul/admin_order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setStatus('New');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('admin_azul_amin_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_order_show", methods={"GET"})
     */
    public function show(Order $order, EntityManagerInterface $em): Response
    {
      
        $user = $order->getUser();
        $carrier = $em->getRepository(Carrier::class)->findOneByName($order->getCarrierName());
   
        
         foreach($user->getAddresses() as $address){
           
         }
        return $this->render('admin_azul/admin_order/show.html.twig', [
            'order' => $order,
            'user' => $user,
            'carrier' => $carrier
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order, Manager $orderManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $data = [
            'type' => 'success',
            'message' => 'La commande a été mis à jour avec succés !',
         
           ] ;
        $success =  $orderManager->newBySubmitForm($form,$order,$request, $data);
        if($success){
         return $this->redirectToRoute('admin_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_order_delete", methods={"POST"})
     */
    public function delete(Request $request, Order $order,  Manager $orderManager): Response
    {
       
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
        
            $data = [
                'type' => 'success',
                'message' => 'La commande  a été supprimé avec succés !'
               ] ;
            $orderManager->remove($order,$request,$data);
           
        }

        return $this->redirectToRoute('admin_order_index', [], Response::HTTP_SEE_OTHER);
    }

    
      /**
     * @Route("/{id}/shipped", name="admin_order_shipped", methods={"GET","POST"})
     */
    public function shipped( Order $order, EntityManagerInterface $em)
    {
       
        if($this->getUser() &&  in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
          
      
            $order->setStatus("Livraison en cours");
            $em->flush();
            return $this->redirectToRoute('admin_order_show', ['id' => $order->getId()]);
        }
      
    }
     /**
     * @Route("/{id}/shipped-final", name="admin_order_shippedfinal", methods={"GET","POST"})
     */
    public function shippedFinal( Order $order, EntityManagerInterface $em)
    {
     
        if($this->getUser() &&  in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
          
      
            $order->setStatus("Commande livrée");
        
            $em->flush();
            return $this->redirectToRoute('admin_order_show', ['id' => $order->getId()]);
        }
      
    }
}
