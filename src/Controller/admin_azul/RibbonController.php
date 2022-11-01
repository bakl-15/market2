<?php

namespace App\Controller\admin_azul;

use App\Entity\Tags;
use App\Form\TagsType;
use App\Manager\Manager;
use App\Manager\CategoryManager;
use App\Repository\TagsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/ribbon")
 */
class RibbonController extends AbstractController
{
    /**
     * @Route("/", name="admin_azul_ribbon_index", methods={"GET"})
     */
    public function index(TagsRepository $tagsRepository): Response
    {
        return $this->render('admin_azul/ribbon/index.html.twig', [
            'tags' => $tagsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_azul_ribbon_new", methods={"GET","POST"})
     */
    public function new(Request $request, Manager $manager): Response
    {
        $tag = new Tags();
        $form = $this->createForm(TagsType::class, $tag);
   
        /***************************************** */
        $data = [
            'type' => 'success',
            'message' => 'Le ribbon a été envoyé avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form,$tag,$request, $data);
     
    
       if($success){
       
    
           return $this->redirectToRoute('admin_azul_ribbon_index', [], Response::HTTP_SEE_OTHER);
        }
        /******************************************* */
        return $this->renderForm('admin_azul/ribbon/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

 

    /**
     * @Route("/{id}/edit", name="admin_azul_ribbon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tags $tag , Manager $manager): Response
    {
        $form = $this->createForm(TagsType::class, $tag);
     
                            /***************************************** */
                            $data = [
                                'type' => 'success',
                                'message' => 'Le ribbon a été envoyé avec succés !',
                            ] ;
                            $success =  $manager->newBySubmitForm($form,$tag,$request, $data);


                            if($success){

                        
                            return $this->redirectToRoute('admin_azul_ribbon_index', [], Response::HTTP_SEE_OTHER);
                            }
                            /******************************************* */
        return $this->renderForm('admin_azul/ribbon/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_azul_ribbon_delete", methods={"POST"})
     */
    public function delete(Request $request, Tags $tag, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le ribbon a été supprimé avec succés !'
               ] ;
           $manager->remove($tag,$request,$data);
        }

        return $this->redirectToRoute('admin_azul_ribbon_index', [], Response::HTTP_SEE_OTHER);
    }
}
