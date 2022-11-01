<?php

namespace App\Controller\admin_azul\settings;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Manager\CategoryManager;
/**
 * @Route("/azul-admin/settings/association")
 */
class HomeAssociationController extends AbstractController
{
    /**
     * @Route("/", name="admin_azul_settings_home_association_index", methods={"GET"})
     */
    public function index(AssociationRepository $associationRepository): Response
    {
        return $this->render('admin_azul/admin_settings/home_association/index.html.twig', [
            'associations' => $associationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_azul_settings_home_association_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        CategoryManager $manager
    ): Response
    {
       
        
         //*********************************** */
         $association = new Association();
         $form = $this->createForm(AssociationType::class, $association);
         $param = $this->getParameter('category_directory');
         $data = [
             'type' => 'success',
             'message' => 'L\'association a été créé avec succés !',
             'directory' => $param
            ] ;
         $success =  $manager->newCategoryBySubmitForm($form,  $association,$request, $data);
         if($success){
            return $this->redirectToRoute('admin_azul_settings_home_association_index', [], Response::HTTP_SEE_OTHER);
        }
         //************************************ */
      

        return $this->renderForm('admin_azul/admin_settings/home_association/new.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin_azul_settings_home_association_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Association $association,  CategoryManager $manager): Response
    {
        
         //*********************************** */
      
         $form = $this->createForm(AssociationType::class, $association);
         $param = $this->getParameter('category_directory');
         $data = [
             'type' => 'success',
             'message' => 'L\'association a été mis à jour avec succés !',
             'directory' => $param
            ] ;
         $success =  $manager->newCategoryBySubmitForm($form,  $association,$request, $data);
         if($success){
            return $this->redirectToRoute('admin_azul_settings_home_association_index', [], Response::HTTP_SEE_OTHER);
        }
         //************************************ */


        return $this->renderForm('admin_azul/admin_settings/home_association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_azul_settings_home_association_delete", methods={"POST"})
     */
    public function delete(Request $request, Association $association): Response
    {
        if ($this->isCsrfTokenValid('delete'.$association->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_azul_settings_home_association_index', [], Response::HTTP_SEE_OTHER);
    }
}
