<?php

namespace App\Controller\admin_azul;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/azul-admin", name="azul_admin_index")
     */
    public function index(): Response
    {
        return $this->render('admin_azul/index.html.twig');
    }
}
