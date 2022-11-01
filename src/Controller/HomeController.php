<?php

namespace App\Controller;

use App\Entity\NavLarge;
use App\Service\CartService;
use App\Manager\ProductManager;
use App\Manager\CategoryManager;
use App\Manager\SettingsManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $settingsManager;
    private $productManager;
    public function __construct(
        SettingsManager $settingsManager,
        ProductManager $productManager
    )
    {
        $this->settingsManager = $settingsManager;
        $this->productManager = $productManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {   
        
        return $this->render('home/index.html.twig',[
            'productBestSeller' => $this->productManager->getProductIsBestSeller(),
            'productNewArrival' => $this->productManager->getProductIsNewArrival(),
            'productIsFeatured' => $this->productManager->getProductIsFeatured(),
            'productNew' =>        $this->productManager->getProductIsNew(),
            'productSecondHand' => $this->productManager->getProductIsSH(),
            'slides' => $this->settingsManager->getSlider(),
            'productsNewNeuf' => $this->productManager->getProductsNewNeuf(),
            'productsNewOccasion' => $this->productManager->getProductsNewOccasion(),
            'productsNewEcolo' => $this->productManager->getProductsNewEcolo(),
            'homeDecovers' => $this->settingsManager->getHomeDecover(),
            'associations'  => $this->settingsManager->getAssociations(),
            'productsFlash'  => $this->settingsManager->getProductsFlash(),
        ]);
    }
}   
