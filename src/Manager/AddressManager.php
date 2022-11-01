<?php

namespace App\Manager;

use App\Entity\Address;
use App\Manager\Manager;

/**
 * permit de recupérer les addresses pour l'utilisateur
 */
class AddressManager extends Manager {

    public function getAddressesByUser($user){
        $rep = $this->em->getRepository(Address::class);
        return $rep->findByUser($user);
    }

}