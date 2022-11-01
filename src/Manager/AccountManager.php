<?php

namespace App\Manager;

use App\Entity\Address;
use App\Entity\Order;
use App\Manager\Manager;

/**
 * permit de recupérer les addresses pour l'utilisateur
 */
class AccountManager extends Manager {

    public function getPaidOrders($user){
        $rep = $this->em->getRepository(Order::class);
        $orders = $rep->findBy(['isPaid' => true, 'user' => $user],['id' => 'DESC']);
        return $orders;

    }
    public function getNotPaidOrders($user){
        $rep = $this->em->getRepository(Order::class);
        $orders = $rep->findBy(['isPaid' => false, 'user' => $user],['id' => 'DESC']);
        return $orders;

    }
    public function getAllOrders($user){
        $rep = $this->em->getRepository(Order::class);
        $orders = $rep->findBy(['user' => $user],['id' => 'DESC']);
        return $orders;

    }

}