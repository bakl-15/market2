<?php

namespace App\Controller\admin_azul;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminLoginController extends AbstractController
{
    /**
     * @Route("/azul-admin/login", name="admin_azul_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
       
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('admin_azul/admin_login/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
