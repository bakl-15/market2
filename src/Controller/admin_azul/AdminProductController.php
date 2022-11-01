<?php

namespace App\Controller\admin_azul;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\Admin\ProductType;
use App\Manager\ProductManager;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/azul-admin/products")
 */
class AdminProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin_azul/admin_product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_product_new")
     */
    public function new(Request $request, ProductManager $productManager ): Response
    {
        $product = new Product();
        $param = $this->getParameter('images_directory');
        $form = $this->createForm(ProductType::class, $product);
         
        $data = [
            'type' => 'success',
            'message' => 'Le produit a été créé avec succés !',
            'directory' => $param
           ] ;
        $success =  $productManager->newProductBySubmitForm($form, $product, $request, $data);
        if($success){
            
            return $this->redirectToRoute('admin_product_index', [], Response::HTTP_SEE_OTHER);
        }
      
        return $this->renderForm('admin_azul/admin_product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin_azul/admin_product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product, ProductManager $productManager): Response
    {
        $images = $product->getImages();
        $product->ressetImages();
    
        $param = $this->getParameter('images_directory');
        $form = $this->createForm(ProductType::class, $product);
    
        $data = [
            'type' => 'success',
            'message' => 'Le produit a été créé avec succés !',
            'directory' => $param
           ] ;
        $success =  $productManager->newProductBySubmitForm($form, $product, $request, $data);
        if($success){
            
            return $this->redirectToRoute('admin_product_index', [], Response::HTTP_SEE_OTHER);
        }
      
        return $this->renderForm('admin_azul/admin_product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
            'images' => $images
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductManager $productManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le produit a été supprimé avec succés !',
               ] ;
            $productManager->remove($product, $request, $data);
        }

        return $this->redirectToRoute('admin_product_index', [], Response::HTTP_SEE_OTHER);
    }

     /**
      * @Route("/delete/image/{id}", name="admin_product_delete_image", methods={"DELETE"})
      */
    public function deleteImage(Image $image, Request $request, ProductManager $productManager)
    {
        $data = json_decode($request->getContent(), true);
     
        $infos = [
            'type' => 'success',
            'message' => 'L\' a été supprimé avec succés !',
           ] ;
      
    
     
       if($this->isCsrfTokenValid('delete'. $image->getId(), $data['_token'])){
           $name = $image->getUrl();
           unlink($this->getParameter('images_directory') . '/' . $name);

           $productManager->remove($image, $request, $infos);
           return new JsonResponse(['success' => 'ok' ]);
       }else{
        return new JsonResponse(['error' => 'token invalid'], 400);
       }
    }
}
