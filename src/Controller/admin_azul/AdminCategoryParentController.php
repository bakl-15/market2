<?php

namespace App\Controller\admin_azul;

use App\Entity\CategoryParent;
use App\Manager\CategoryManager;
use App\Form\Admin\CategoryParentType;
use App\Repository\CategoryParentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/category-parent")
 */
class AdminCategoryParentController extends AbstractController
{
     /**
     * @var CategoryManager $categoryManager
     */
    private $categoryManager;
     
     public function __construct(CategoryManager $categoryManager){
        $this->categoryManager = $categoryManager;
     }
    /**
     * @Route("/", name="admin_category_parent_index", methods={"GET"})
     */
    public function index(CategoryParentRepository $categoryParentRepository): Response
    {
        return $this->render('admin_azul/admin_category_parent/index.html.twig', [
            'category_parents' => $categoryParentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_category_parent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryParent = new CategoryParent();
        $form = $this->createForm(CategoryParentType::class, $categoryParent);
        $param = $this->getParameter('category_directory');
       
        $data = [
            'type' => 'success',
            'message' => 'La catégorie a été créée avec succés !',
            'directory' => $param
           ] ;
        $success =  $this->categoryManager->newCategoryBySubmitForm($form, $categoryParent,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_category_parent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_category_parent/new.html.twig', [
            'category_parent' => $categoryParent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_parent_show", methods={"GET"})
     */
    public function show(CategoryParent $categoryParent): Response
    {
        return $this->render('admin_azul/admin_category_parent/show.html.twig', [
            'category_parent' => $categoryParent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_category_parent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryParent $categoryParent): Response
    {
     
        $form = $this->createForm(CategoryParentType::class, $categoryParent);
        $param = $this->getParameter('category_directory');
       
        $data = [
            'type' => 'success',
            'message' => 'La catégorie a été mis avec succés !',
            'directory' => $param
           ] ;
        $success =  $this->categoryManager->newCategoryBySubmitForm($form, $categoryParent,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_category_parent_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('admin_azul/admin_category_parent/edit.html.twig', [
            'category_parent' => $categoryParent,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_parent_delete", methods={"POST"})
     */
    public function delete(Request $request, CategoryParent $categoryParent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryParent->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'La catégorie a été supprimé avec succés !'
               ] ;
           $this->categoryManager->remove($categoryParent,$request,$data);
        }

        return $this->redirectToRoute('admin_category_parent_index', [], Response::HTTP_SEE_OTHER);
    }
}
