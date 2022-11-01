<?php

namespace App\Controller\admin_azul;

use App\Entity\Comment;
use App\Manager\Manager;
use App\Form\Comment1Type;
use App\Form\Admin\AdminCommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/comment")
 */
class AdminCommentController extends AbstractController
{
    /**
     * @Route("/", name="admin_comment_index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('admin_azul/admin_comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_comment_new", methods={"GET","POST"})
     */
    public function new(Request $request, Manager $manager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(AdminCommentType::class, $comment);
     
        $data = [
            'type' => 'success',
            'message' => 'Le produit a été créé avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form, $comment, $request, $data);
        if($success){
            
            return $this->redirectToRoute('admin_comment_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('admin_azul/admin_comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('admin_azul/admin_comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment, Manager $manager): Response
    {
        $form = $this->createForm(AdminCommentType::class, $comment);
        $data = [
            'type' => 'success',
            'message' => 'Le produit a été mis à jour avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form, $comment, $request, $data);
        if($success){
            
            return $this->redirectToRoute('admin_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_comment_delete", methods={"POST"})
     */
    public function delete(Request $request, Comment $comment, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le commentaire a été supprimé avec succés !'
               ] ;
           $manager->remove($comment,$request,$data);
        }

        return $this->redirectToRoute('admin_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
