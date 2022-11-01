<?php

namespace App\twig;

use App\Entity\NavLarge;
use App\Manager\ProductManager;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class OldExtension extends AbstractExtension{
   
     private $em;

     public function  __construct(EntityManagerInterface $em){
         $this->em = $em;
     }
     
    public function getFunctions()
    {
        return [
             new TwigFunction('LargeMenu', [$this, 'getLargeMenu'])
        ];
    }
    
    public function getLargeMenu(){
      $rep = $this->em->getRepository(NavLarge::class);
      $menu = $rep->findAll();
      $data = [];
      foreach($rep->findAll() as $menu ){
          foreach($menu->getCatParente() as $cp){
          $bata[$menu->getName()][] = $cp;
          }
      }
      return $rep->findAll();
    }

}
