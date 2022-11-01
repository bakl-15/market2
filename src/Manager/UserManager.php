<?php

namespace App\Manager;

use App\Entity\Role;
use App\Entity\User;
use App\Manager\Manager;


/**
 * permit de recupérer les addresses pour l'utilisateur
 */
class UserManager extends Manager {

    /**
     * permit de recuperer tous les utilisateurs
     */
    public function getAllUsers(){
        $rep = $this->em->getRepository(User::class);
        return $rep->findAll();
    }
     /**
     * permit d'ajouter un role à l'utilisateur'
     */
    public function addToUserRole(User $user){
        $rep = $this->em->getRepository(Role::class);
        $role = $rep->findOneByTitle('ROLE_USER');
       
        $role->addUser($user);
        $this->em->persist($role);
        $this->em->flush();
    }

    
}