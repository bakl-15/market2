<?php

namespace App\Controller\admin_azul;

use App\Entity\Carrier;
use App\Manager\CarrierManager;
use App\Form\Admin\AdminCarrierType;
use App\Repository\CarrierRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/carrier")
 */
class AdminCarrierController extends AbstractController
{
    /**
     * @var CarrierManager $carrierManager
     */
     private $carrierManager;
      public function __construct(CarrierManager $carrierManager )
      {
           $this->carrierManager =  $carrierManager;
      }
    /**
     * @Route("/", name="admin_carrier_index", methods={"GET"})
     */
    public function index(CarrierRepository $carrierRepository): Response
    {
        return $this->render('admin_azul/admin_carrier/index.html.twig', [
            'carriers' => $this->carrierManager->getAllCarrier(),
        ]);
    }

    /**
     * @Route("/new", name="admin_carrier_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carrier = new Carrier();
        $form = $this->createForm(AdminCarrierType::class, $carrier);
        $data = [
            'type' => 'success',
            'message' => 'Le transporteur  a été créé avec succés !',
           ] ;
        $success =  $this->carrierManager->newBySubmitForm($form,$carrier,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_carrier/new.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_carrier_show", methods={"GET"})
     */
    public function show(Carrier $carrier): Response
    {
        return $this->render('admin_azul/admin_carrier/show.html.twig', [
            'carrier' => $carrier,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_carrier_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Carrier $carrier): Response
    {
        $form = $this->createForm(AdminCarrierType::class, $carrier);
        $data = [
            'type' => 'success',
            'message' => 'Le transporteur  a été mis avec succés !',
           ] ;
        $success =  $this->carrierManager->newBySubmitForm($form,$carrier,$request, $data);
        if($success){
            return $this->redirectToRoute('admin_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_carrier/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_carrier_delete", methods={"POST"})
     */
    public function delete(Request $request, Carrier $carrier): Response
    {
        $data = [
            'type' => 'success',
            'message' => 'Le transporteur  a été supprimé avec siccés !',
           ] ;
        if ($this->isCsrfTokenValid('delete'.$carrier->getId(), $request->request->get('_token'))) {
           $this->carrierManager->remove($carrier,$request, $data);
        }

        return $this->redirectToRoute('admin_carrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
