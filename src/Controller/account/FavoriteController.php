<?php

namespace App\Controller\account;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
class FavoriteController extends AbstractController
{
    /**
     * @Route("/account/favorite", name="favorite_index")
     */
    public function index(

        Request $request, 
        PaginatorInterface $paginator
    ): Response
    {
        $data = $this->getUser()->getFavorites();
        $products = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('account/favorite/index.html.twig', [
          'products' => $products
        ]);
    }
    /**
     * @Route("/account/favorite/{id}", name="favorite_add")
     */
    public function addToFavorites(
        Product $product,
        EntityManagerInterface $em
        
        )
    { 
        if(! $this->getUser()){
           return $this->redirectToRoute('app_login');
        }
        if($product){
           $this->getUser()->addFavorite($product);
           $em->flush();
           $this->addFlash('success', " {$product->getName()} a été ajouté vos favories avec succés");
           $this->redirectToRoute('app_login');
           return $this->redirectToRoute('favorite_index');
        }
    }
     /**
     * @Route("/account/favorite/{id}", name="favorite_remove")
     */
    public function removeFromFavorites(Product $product)
    { 
        if(! $this->getUser()){
           return $this->redirectToRoute('app_login');
        }
        if($product){
           $this->getUser()->removeFavorite($product);
           $this->addFlash('success', " {$product->getName()} a été supprimé de vos favories avec succés");
          return $this->redirectToRoute('favorite_index');
        }
    }


    
}
