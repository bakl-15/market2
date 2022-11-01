<?php

namespace App\Controller\search;

use App\Data\SearchProduct;
use App\Form\SearchFormType;
use App\Form\Admin\SearchType;
use App\Service\SearchService;
use App\Manager\ProductManager;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\CategoryParentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    
    /**
     * @var SearchService
     */
    public $searchService;

    /**
     * AdminSearchController constructor.
     * @param SearchService $searchService
     */
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchBar()
    {
        $form = $this->createForm(SearchType::class, null, [
            'action' => $this->generateUrl("search_results")
        ]);
        
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search-results", name="search_results")
     */
    public function searchBarResult(
        Request $request,
         PaginatorInterface $paginator,
         CategoryParentRepository $cpRep,
         ProductManager $productManager
         )
    {
         //--------------------------------------

        
        
         $categoryParent = $cpRep->findAll();
         $searchProduct = new SearchProduct;
         $form2 = $this->createForm(SearchFormType::class, $searchProduct);
         [$min, $max] =[0,700];
         $form2->handleRequest($request);
         if($form2->isSubmitted() && $form2->isValid()){
            $data =  $productManager->findBySearch($searchProduct);
            [$min, $max] = $productManager->getMinMax($searchProduct);
            $products = $paginator->paginate(
                $data,
                $request->query->getInt('page',1),
                8
            );
        }
         //--------------------------------------
        $categoryParent = $cpRep->findAll();
        $form = $this->createForm(SearchType::class, null, [
            'action' => $this->generateUrl("search_results")
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
             $formData = $form->getData();
            
             if($formData['category']->getName() === "Categories"){
                $formData['category'] = null;
             }
           
             $data = $this->searchService->getProductsBySearch($formData);
             $products = $paginator->paginate(
                $data,
                $request->query->getInt('page',1),
                8
            );
        }
        return $this->render('product/productFilter.html.twig', [
            'products' => $products,
            'categoryParents' => $categoryParent,
            'form' => $form2->createView(),
            'min' => $min,
            'max' => $max
        ]);
    }
}
