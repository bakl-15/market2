<?php

namespace App\Controller\account;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AccountPasswordController extends AbstractController
{
    /**
     * @Route("/account/password", name="account_password")
     */
    public function index( Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $oldPassword = $form->get('old_password')->getData();
            if($encoder->isPasswordValid($user, $oldPassword)){
                  $newPassword =  $form->get('new_password')->getData();
                  $user->setPassword(
                    $encoder->hashPassword(
                            $user,
                            $newPassword
                        )
                    );

                    $entityManager = $this->getDoctrine()->getManager();
           
                    $entityManager->persist($user);
                    $entityManager->flush();
                    
                   $this->addFlash('success', 'Le mot de passe a été modifié avec succés');
        
                    return $this->redirectToRoute('account_profil');
        
            }
        }
        return $this->render('account/accountPassword/index.html.twig', [
           'form' => $form->createView()
        ]);
    }
}
