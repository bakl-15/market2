<?php

namespace App\Controller\admin_azul\settings;

use App\Manager\Manager;
use App\Entity\SellFlash;
use App\Form\SellFlashType;
use App\Repository\SellFlashRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/settings/flash")
 */
class HomeFlashController extends AbstractController
{
    /**
     * @Route("/", name="admin_azul_settings_home_flash_index", methods={"GET"})
     */
    public function index(SellFlashRepository $sellFlashRepository): Response
    {
        return $this->render('admin_azul/flashs/home_flash/index.html.twig', [
            'sell_flashes' => $sellFlashRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_azul_settings_home_flash_new", methods={"GET","POST"})
     */
    public function new(Request $request, Manager $manager): Response
    {
        $sellFlash = new SellFlash();
        $form = $this->createForm(SellFlashType::class, $sellFlash);
        $data = [
            'type' => 'success',
            'message' => 'Le flash a été créé avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form,$sellFlash,$request, $data);
        if($success){
           
            return $this->redirectToRoute('admin_azul_settings_home_flash_index', [], Response::HTTP_SEE_OTHER);
     
        }

       

        return $this->renderForm('admin_azul/flashs/home_flash/new.html.twig', [
            'sell_flash' => $sellFlash,
            'form' => $form,
        ]);
    }

   

    /**
     * @Route("/{id}/edit", name="admin_azul_settings_home_flash_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SellFlash $sellFlash, Manager $manager): Response
    {
        $form = $this->createForm(SellFlashType::class, $sellFlash);
        $data = [
            'type' => 'success',
            'message' => 'Le flash a été mis à jour avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form,$sellFlash,$request, $data);
        if($success){
           
            return $this->redirectToRoute('admin_azul_settings_home_flash_index', [], Response::HTTP_SEE_OTHER);
     
        }


        return $this->renderForm('admin_azul/flashs/home_flash/edit.html.twig', [
            'sell_flash' => $sellFlash,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_azul_settings_home_flash_delete", methods={"POST"})
     */
    public function delete(Request $request, SellFlash $sellFlash, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sellFlash->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le flash a été supprimé avec succés !'
               ] ;
           $manager->remove($sellFlash,$request,$data);
        }

        return $this->redirectToRoute('admin_azul_settings_home_flash_index', [], Response::HTTP_SEE_OTHER);
    }
}
