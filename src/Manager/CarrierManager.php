<?php

namespace App\Manager;


use App\Entity\Carrier;
use App\Manager\Manager;


/**
 * permit de recupérer les transporteurs 
 */
class CarrierManager extends Manager {
     
  
   /**
    * permis de recupérer tous les transporteurs 
    */
     public function getAllCarrier(){
       return  $this->em->getRepository(Carrier::class)->findAll();
     }

}