<?php

namespace App\Controller\admin_azul\settings;

use App\Entity\HomeSlider;
use App\Form\Admin\HomeSliderType;
use App\Manager\SettingsManager;
use App\Repository\HomeSliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/azul-admin/settings/homeSlider")
 */
class HomeSliderController extends AbstractController
{
    /**
     * @Route("/", name="admin_settings_homeSlider_index", methods={"GET"})
     */
    public function index(HomeSliderRepository $homeSliderRepository): Response
    {
        return $this->render('admin_azul/admin_settings/home_slider/index.html.twig', [
            'home_sliders' => $homeSliderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_settings_homeSlider_new", methods={"GET","POST"})
     */
    public function new(Request $request, SettingsManager $settingsManager): Response
    {
        $homeSlider = new HomeSlider();
        $form = $this->createForm(HomeSliderType::class, $homeSlider);
        $param = $this->getParameter('slider_directory');
      
         
        $data = [
            'type' => 'success',
            'message' => 'Le slide a été créée avec succés !',
            'slider' => $param
           ] ;
        $success =  $settingsManager->newSliderBySubmitForm($form,$homeSlider,$request, $data);
      
        if($success){
            return $this->redirectToRoute('admin_settings_homeSlider_index', [], Response::HTTP_SEE_OTHER);
        }
           
       

        return $this->renderForm('admin_azul/admin_settings/home_slider/new.html.twig', [
            'home_slider' => $homeSlider,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_settings_homeSlider_show", methods={"GET"})
     */
    public function show(HomeSlider $homeSlider): Response
    {
        return $this->render('admin_azul/admin_settings/home_slider/show.html.twig', [
            'home_slider' => $homeSlider,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_settings_homeSlider_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HomeSlider $homeSlider, SettingsManager $settingsManager): Response
    {
        $form = $this->createForm(HomeSliderType::class, $homeSlider);
        $param = $this->getParameter('slider_directory');
      
         
        $data = [
            'type' => 'success',
            'message' => 'Le slide a été mis à jour avec succés !',
            'slider' => $param
           ] ;
        $success =  $settingsManager->newSliderBySubmitForm($form,$homeSlider,$request, $data);
      
        if($success){
            return $this->redirectToRoute('admin_settings_homeSlider_index', [], Response::HTTP_SEE_OTHER);
        }
           
       

        return $this->renderForm('admin_azul/admin_settings/home_slider/edit.html.twig', [
            'home_slider' => $homeSlider,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_settings_homeSlider_delete", methods={"POST"})
     */
    public function delete(Request $request, HomeSlider $homeSlider, SettingsManager $settingsManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homeSlider->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le slide  a été supprimé avec siccés !',
               ] ;
            if ($this->isCsrfTokenValid('delete'.$homeSlider->getId(), $request->request->get('_token'))) {
               $settingsManager->remove($homeSlider,$request, $data);
            }
    
            return $this->redirectToRoute('admin_settings_homeSlider_index', [], Response::HTTP_SEE_OTHER);
   
        }

    }
}
