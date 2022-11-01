<?php

namespace App\Controller\product;

use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\Category;

use App\Form\CommentType;
use App\Data\SearchProduct;
use App\Form\SearchFormType;
use App\Entity\CategoryParent;
use App\Manager\ProductManager;
use App\Manager\SettingsManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\CategoryParentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $ProductManager;
    


    public function __construct(
        ProductManager $productManager
        
    )
    {
         $this->ProductManager = $productManager;
         
    }
    /**
     * @Route("/produits", name="product")
     */
    public function index(
        Request $request, 
        PaginatorInterface $paginator,
         CategoryParentRepository $cpRep
         ): Response
    {
        $data = $this->ProductManager->getAllProducts();
        [$min, $max] =[0,0];
        $categoryParent = $cpRep->findAll();
        $searchProduct = new SearchProduct;
        $form = $this->createForm(SearchFormType::class, $searchProduct);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data =  $this->ProductManager->findBySearch($searchProduct);
            [$min, $max] = $this->ProductManager->getMinMax($searchProduct);
        }
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
        return $this->render('product/AllProductsWithAD.html.twig',[
            'products' => $products,
            'categoryParents' => $categoryParent,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
           
        ]);
    }
     /**
     * @Route("/produits-filtre", name="product-filter")
     */
    public function filtre(
        Request $request, 
        PaginatorInterface $paginator
        ): Response
    {
        $data = $this->ProductManager->getAllProducts();
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
        return $this->render('product/productFilter.html.twig',[
            'products' => $products 
        ]);
    }
    /**
     * @Route("/produits-filtre-by-category/{id}", name="product-filter-category")
     */
    public function filtreByCategory(
         Request $request,
         PaginatorInterface $paginator,
         Category $category,
         CategoryParentRepository $cpRep
         ): Response
    {


        //--------------------------------------

        $data = $category->getProducts();
        [$min, $max] =[0,0];
        $categoryParent = $cpRep->findAll();
        $searchProduct = new SearchProduct;
        $form = $this->createForm(SearchFormType::class, $searchProduct);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data =  $this->ProductManager->findBySearch($searchProduct);
            [$min, $max] = $this->ProductManager->getMinMax($searchProduct);
        }
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            6
        );
        //--------------------------------------
        
      
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            8
        );
        return $this->render('product/productFilter.html.twig',[
            'products' => $products,
            'categoryParents' => $categoryParent,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
        ]);
    }
     /**
     * @Route("/produits-filtre-ecolo", name="product-filter-ecolo")
     */
    public function filtreWithEcolo(Request $request, PaginatorInterface $paginator): Response
    {
        $data = $this->ProductManager->getProductIsEcolo();
      
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            8
        );
        return $this->render('product/AllProductsWithAD.html.twig',[
            'products' => $products
        ]);
    }
     /**
     * @Route("/produits/{id}", name="product_show")
     */
    public function show(
        Request $request,
        ?Product $product,
         PaginatorInterface $paginator,
         EntityManagerInterface $em,
         SettingsManager $settingsManager
         ): Response
    {

        if(! $product){
           
            return $this->redirectToRoute('home');
        }else{
            $data = $product->getComments();
               $comments = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            4
        );
         $comment = new  Comment();
        $form =  $this->createForm(CommentType::class, $comment);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()){
             if(! $this->getUser()){
               $this->addFlash('danger', 'Vous pouvez ajouter un commentaire, veuillez vous connecter à votre compte');
               return $this->redirectToRoute('product_show',['id' => $product->getId()]);
             }else{
               $comment->setProduct($product)
                       ->setAuthor($this->getUser());
               $em->persist($comment);
               $em->flush();
               $this->addFlash('success', 'Le commentaire a été ajouté avec succés');
               return $this->redirectToRoute('product_show',['id' => $product->getId()]);
            

             }
         }
            return $this->render('product/product-show.html.twig',[
                'product' => $product,
                'products' => $this->ProductManager->getProductByCategory($product),
                'comments' => $comments,
                'form' => $form->createView(),
                'productsFlash'  => $settingsManager->getProductsFlash(),
            ]);
        }
      
      
    }
}
