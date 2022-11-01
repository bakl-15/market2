<?php

namespace App\Controller\admin_azul\settings;

use App\Entity\HomeDecouver;
use App\Form\HomeDecouverType;
use App\Manager\CategoryManager;
use App\Repository\HomeDecouverRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/azul/home/decouver")
 */
class HomeDecouverController extends AbstractController
{
    /**
     * @Route("/", name="admin_azul_home_decouver_index", methods={"GET"})
     */
    public function index(HomeDecouverRepository $homeDecouverRepository): Response
    {
        return $this->render('admin_azul/admin_settings/home_decouver/index.html.twig', [
            'home_decouvers' => $homeDecouverRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_azul_home_decouver_new", methods={"GET","POST"})
     */
    public function new(Request $request,  CategoryManager $manager): Response
    {
      
   
      
        //*********************************** */
        $homeDecouver = new HomeDecouver();
        $form = $this->createForm(HomeDecouverType::class, $homeDecouver);
        $param = $this->getParameter('category_directory');
        $data = [
            'type' => 'success',
            'message' => 'Le blog a été créé avec succés !',
            'directory' => $param
           ] ;
        $success =  $manager->newCategoryBySubmitForm($form,  $homeDecouver,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_azul_home_decouver_index', [], Response::HTTP_SEE_OTHER);
        }
        //************************************ */

        return $this->renderForm('admin_azul/admin_settings/home_decouver/new.html.twig', [
            'home_decouver' => $homeDecouver,
            'form' => $form,
        ]);
    }

  

    /**
     * @Route("/{id}/edit", name="admin_azul_home_decouver_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
         HomeDecouver $homeDecouver,
         CategoryManager $manager
         ): Response
    {
        $form = $this->createForm(HomeDecouverType::class, $homeDecouver);
        $param = $this->getParameter('category_directory');
        $data = [
            'type' => 'success',
            'message' => 'Le blog a été mis à jour avec succés !',
            'directory' => $param
           ] ;
        $success =  $manager->newCategoryBySubmitForm($form,  $homeDecouver,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_azul_home_decouver_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_settings/home_decouver/edit.html.twig', [
            'home_decouver' => $homeDecouver,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_azul_home_decouver_delete", methods={"POST"})
     */
    public function delete(Request $request, HomeDecouver $homeDecouver): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homeDecouver->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($homeDecouver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_azul_home_decouver_index', [], Response::HTTP_SEE_OTHER);
    }
}
