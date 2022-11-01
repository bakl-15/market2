<?php

namespace App\Controller\admin_azul;
use App\Manager\Manager;
use App\Entity\Coupon;
use App\Form\CouponType;
use App\Repository\CouponRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/azul-admin/coupon")
 */
class CouponController extends AbstractController
{
    /**
     * @Route("/", name="admin_azul_coupon_index", methods={"GET"})
     */
    public function index(CouponRepository $couponRepository): Response
    {
        return $this->render('admin_azul/coupon/index.html.twig', [
            'coupons' => $couponRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_azul_coupon_new", methods={"GET","POST"})
     */
    public function new(Request $request, Manager $manager): Response
    {
        $coupon = new Coupon();
        $form = $this->createForm(CouponType::class, $coupon);
        $data = [
            'type' => 'success',
            'message' => 'Le coupon a été créé avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form,$coupon,$request, $data);
        if($success){
           
            return $this->redirectToRoute('admin_azul_coupon_index', [], Response::HTTP_SEE_OTHER);
       
        }


        return $this->renderForm('admin_azul/coupon/new.html.twig', [
            'coupon' => $coupon,
            'form' => $form,
        ]);
    }

   

    /**
     * @Route("/{id}/edit", name="admin_azul_coupon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coupon $coupon, Manager $manager): Response
    {
        $form = $this->createForm(CouponType::class, $coupon);
        $data = [
            'type' => 'success',
            'message' => 'Le coupon a été mis à jour avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form,$coupon,$request, $data);
        if($success){
           
            return $this->redirectToRoute('admin_azul_coupon_index', [], Response::HTTP_SEE_OTHER);
       
        }

        return $this->renderForm('admin_azul/coupon/edit.html.twig', [
            'coupon' => $coupon,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_azul_coupon_delete", methods={"POST"})
     */
    public function delete(Request $request, Coupon $coupon, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coupon->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le coupon a été supprimé avec succés !'
               ] ;
           $manager->remove($coupon,$request,$data);
        }

        return $this->redirectToRoute('admin_azul_coupon_index', [], Response::HTTP_SEE_OTHER);
    }
}
