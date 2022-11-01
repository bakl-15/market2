<?php

namespace App\Controller\Contact;

use App\Entity\User;
use App\Entity\Contact;
use App\Manager\Manager;
use App\Form\ContactType;
use App\Entity\EmailModel;
use App\Service\EmailSenderService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function new(Manager $manager, Request $request, EmailSenderService $emailSenderService): Response
    {
      
        $contact = new Contact;
        $form = $this->createForm(ContactType::class,$contact);
        $data = [
            'type' => 'success',
            'message' => 'Le Méssage a été envoyé avec succés !',
           ] ;
        $success =  $manager->newBySubmitForm($form,$contact,$request, $data);
     
       
       if(!$success){
        $data = [
            'type' => 'danger',
            'message' => 'Le Méssage a été envoyé avec succés !',
           ] ;
        }
        $user = (new User())
        ->setEmail("baakellolache@gmail.com")
        ->setFirstName('Azul')
        ->setLastName('Contact');
       $email = (new EmailModel())
          ->setTitle('Bonjour' . $user->fullname())
          ->setSubject('Nouveau contact du sit Azul.fr')
          ->setContent(
              '<br> de : ' . $contact->getEmail()
              . '<br> Nom : ' . $contact->getName()
              . '<br> Sujet : ' . $contact->getSubject()
              . '<br> <br> : ' . $contact->getContent()
          );
         $emailSenderService->sendEmailNotificationByMailJet($user,$email);
        return $this->render('contact/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
