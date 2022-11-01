<?php

namespace App\Manager;

use App\Manager\Manager;
use App\Entity\HomeSlider;
use App\Entity\Association;
use App\Entity\HomeDecouver;
use App\Entity\SellFlash;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class SettingsManager extends Manager {
    public function newSliderBySubmitForm( Form $form, HomeSlider $homeSlider,Request $request, $data): bool
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
         
          if($form->get('image')->getData()){
            
                 if($homeSlider->getImage()) {
                  unlink( $data['slider'] . '/' . $homeSlider->getImage());
                 }
             
              $image = $form->get('image')->getData();
              $image =  $this->fileUploader->upload($image, $data['slider']);
              $homeSlider->setImage($image);
        
          }
            $this->save($homeSlider);
            
            $request->getSession()->getFlashBag()->add(
                $data['type'],
                $data['message'],
  
            );
             return true;
        }else{
            return false;
        }
       
   }
  
   public function getSlider(){
    $rep =  $this->em->getRepository(HomeSlider::class);
    return $rep->findBy(['isDisplayed' => true] );
   }
   public function getHomeDecover(){
    $rep =  $this->em->getRepository(HomeDecouver::class);
    return $rep->findAll();
   }
   public function getAssociations(){
    $rep =  $this->em->getRepository(Association::class);
    return $rep->findAll();
   }

   public function getProductsFlash(){
    $rep =  $this->em->getRepository(SellFlash::class);
    return $rep->findAll();
   }
}