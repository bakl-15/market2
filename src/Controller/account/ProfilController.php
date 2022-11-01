<?php

namespace App\Controller\account;

use App\Entity\Order;
use App\Manager\AccountManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends AbstractController
{
    /**
     * @Route("/account/", name="account_profil")
     */
    public function profil(
      

    ): Response
    {
        $user = $this->getUser();
       
        return $this->render('account/profil/profil.html.twig', [
           'user' => $user
        ]);
    }
   
}
