<?php

namespace App\Controller\admin_azul;

use App\Entity\Contact;
use App\Manager\Manager;
use App\Form\Contact1Type;
use App\Form\Admin\AdminContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/azul-admin/contact")
 */
class AdminContactController extends AbstractController
{
    /**
     * @Route("/", name="admin_contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('admin_azul/admin_contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    

    /**
     * @Route("/{id}", name="admin_contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        return $this->render('admin_azul/admin_contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact, Manager $manager): Response
    {
        $form = $this->createForm(AdminContactType::class, $contact);
        $data = [
            'type' => 'success',
            'message' => 'Le Message contact a été mis avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form, $contact, $request, $data);
        if($success){
            
            return $this->redirectToRoute('admin_contact_index', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('admin_azul/admin_contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_contact_delete", methods={"POST"})
     */
    public function delete(Request $request, Contact $contact, Manager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $data = [
                'type' => 'success',
                'message' => 'Le contact a été supprimé avec succés !'
               ] ;
           $manager->remove($contact,$request,$data);
        }

        return $this->redirectToRoute('admin_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
