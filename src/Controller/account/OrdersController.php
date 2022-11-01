<?php

namespace App\Controller\account;

use App\Entity\Order;
use App\Manager\AccountManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends AbstractController
{
    private $accountManager;
    public function __construct(AccountManager $accountManager)
    {
         $this->accountManager = $accountManager;
    }

   
    /**
     * @Route("/account/orders", name="account_order")
     */
    public function accountOrder(
        Request $request, 
        PaginatorInterface $paginator

    ): Response
    {
        $user = $this->getUser();
        $data = $this->accountManager->getPaidOrders($user);
        $orders = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('account/order/order.html.twig', [
            'orders' => $orders,
        ]);
    }
    /**
     * @Route("/account/order/{id}", name="account_order_show")
     */
    public function show(Order $order): Response
    {
 
        if(! $order || $order->getUser() !== $this->getUser()){
            return $this->redirectToroute('home');
        }
        return $this->render('account/order/detailOrder.html.twig', [
             'order' => $order
        ]);
    }
}
