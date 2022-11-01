<?php

namespace App\Controller\admin_azul\settings;

use App\Entity\NavLarge;
use App\Manager\Manager;

use App\Manager\CategoryManager;

use App\Form\Admin\LargeMenuType;

use App\Repository\NavLargeRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/settings/homeLargeNav")
 */
class HomeLargeNavController extends AbstractController
{
    /**
     * @Route("/", name="admin_settings_homeLargeNav_index", methods={"GET"})
     */
    public function index(NavLargeRepository $navLargeRepository): Response
    {
        return $this->render('admin_azul/admin_settings/home_largeNav/index.html.twig', [
            'navLarges' => $navLargeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_settings_homeLargeNav_new", methods={"GET","POST"})
     */
    public function new(Request $request, CategoryManager $manager): Response
    {
        $largeMenu = new NavLarge();
        $form = $this->createForm(LargeMenuType::class, $largeMenu,['isNew' => 'other']);
       
        $data = [
            'type' => 'success',
            'message' => 'Le menu  a été créé avec succés !',
           ] ;
        $success =  $manager->newCategoryBySubmitForm($form, $largeMenu,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_settings_homeLargeNav_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_settings/home_largeNav/new.html.twig', [
            
            'form' => $form,
        ]);
    }

     /**
     * @Route("/{id}/edit", name="admin_settings_homeLargeNav_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NavLarge $largeMenu, CategoryManager $manager): Response
    {
        $new = 'other';
            if($largeMenu->getName() === 'S.B OCCASION'){
                $new = 'old';
            } elseif($largeMenu->getName() === 'S.B NEUF'){
                $new = 'new';
            }
      
        $form = $this->createForm(LargeMenuType::class, $largeMenu, ['isNew' => $new]);
        $param = $this->getParameter('category_directory');
        $data = [
            'type' => 'success',
            'message' => 'Le menu  a été mis avec succés !',
            'directory' => $param
           ] ;
        $success =  $manager->newCategoryBySubmitForm($form, $largeMenu,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_settings_homeLargeNav_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin_azul/admin_settings/home_largeNav/edit.html.twig', [
            
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_settings_homeLargeNav_delete", methods={"POST"})
     */
    public function delete(Request $request, NavLarge $largeMenu, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'. $largeMenu->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le slide  a été supprimé avec siccés !',
               ] ;
            if ($this->isCsrfTokenValid('delete'.$largeMenu->getId(), $request->request->get('_token'))) {
               $manager->remove($largeMenu,$request, $data);
            }
    
            return $this->redirectToRoute('admin_settings_homeLargeNav_index', [], Response::HTTP_SEE_OTHER);
   
        }

    }
}
