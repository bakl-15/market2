<?php

namespace App\Controller\admin_azul;

use App\Entity\Category;
use App\Form\Admin\CategoryType;
use App\Manager\CategoryManager;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin-azul/category")
 */
class AdminCategoryController extends AbstractController
{
      /**
     * @var CategoryManager $categoryManager
     */
    private $categoryManager;
     
     public function __construct(CategoryManager $categoryManager){
        $this->categoryManager = $categoryManager;
     }

  
    /**
     * @Route("/", name="admin_category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin_azul/admin_category/index.html.twig', [
            'categories' => $this->categoryManager->getAllCategories(),
        ]);
    }

    /**
     * @Route("/new", name="admin_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $param = $this->getParameter('category_directory');
       
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
         
        $data = [
            'type' => 'success',
            'message' => 'La catégorie a été créée avec succés !',
            'directory' => $param
           ] ;
        $success =  $this->categoryManager->newCategoryBySubmitForm($form,$category,$request, $data);
        if($success){
         return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('admin_azul/admin_category/show.html.twig', [
            'category' => $category,
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="admin_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $param = $this->getParameter('category_directory');
        $data = [
            'type' => 'success',
            'message' => 'La catégorie a été mise à jour avec succés !',
            'directory' => $param
           ] ;
        $form = $this->createForm(CategoryType::class, $category);
        $success =  $this->categoryManager->newCategoryBySubmitForm($form,$category,$request, $data);
       
        if($success){
         return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'La catégorie a été supprimé avec succés !'
               ] ;
           $this->categoryManager->remove($category,$request,$data);
        }

        return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
