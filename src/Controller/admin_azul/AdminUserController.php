<?php

namespace App\Controller\admin_azul;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use App\Entity\User;
use App\Entity\Role;
use App\Form\Admin\AdminUserFormType;

use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Service\FileUploader;

/**
 * @Route("/azul-admin/user")
 */
class AdminUserController extends AbstractController
{
    /**
     * @var EmailVerifier
     */
    private $emailVerifier;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @param UserManager $userManager
     */
  
     public function __construct( UserManager $userManager, EmailVerifier $emailVerifier){

        $this->userManager = $userManager;
        $this->emailVerifier = $emailVerifier;
     }
    /**
     * @Route("/", name="admin_user_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_azul/admin_user/index.html.twig', [
            'users' => $this->userManager->getAllUsers(),
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
         UserPasswordHasherInterface $userPasswordHasherInterface,
         UserManager $userManager,
         FileUploader $fileUploader
         ): Response
    {
       
        $user = new User();
        $form = $this->createForm(AdminUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password.
             
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();

            if($form->get('image')->getData()){
                $avatar = $form->get('image')->getData();
                $fileUploader->uploadAvatar($avatar,$user);
            }

            if(! $form->get('image')->getData()){
                $user->setCoverImage('/avatar-user.jpg');
            }
            
             
            if( $form->get('isAdmin')->getData()){
                 $role = $entityManager->getRepository(Role::class)->findOneByTitle('ROLE_ADMIN');
                 $user->addUserRole($role);
             }
           
           
            $entityManager->persist($user);
            $entityManager->flush();
            $userManager->addToUserRole($user);
            // generate a signed url and email it to the user
          
            if( ! $user->isVerified()){
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('contact@azul.fr', 'contact-azul'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            }
           
            // do anything else you need here, like send an email
            $this->addFlash('success', "L'utilisateur <strong>{$user->fullname()}</strong> a été ajouté avec succés ");
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin_azul/admin_user/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin_azul/admin_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        User $user,
        UserPasswordHasherInterface $userPasswordHasherInterface,
        FileUploader $fileUploader
    ): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
      
        $form = $this->createForm(AdminUserFormType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('plainPassword')->getData() !== 'La modification du mot de passe est déconseillée'){
              
                $user->setPassword(
                    $userPasswordHasherInterface->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
            }
            if($form->get('image')->getData()){
               
                $avatar = $form->get('image')->getData();
                if($user->getCoverImage()){
                    unlink( $avatar . '/' . $user->getCoverImage());
                }
               
                $fileUploader->uploadAvatar($avatar,$user);
            }
            $role = $entityManager->getRepository(Role::class)->findOneByTitle('ROLE_ADMIN');
            if( $form->get('isAdmin')->getData()){
             
              if(! $user->getUserRoles()->contains($role)){
                  $user->addUserRole($role);
              }
              
            }else{
                if($user->getUserRoles()->contains($role)){
                    $user->removeUserRole($role);
                }
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur <strong>{$user->fullname()}</strong> a été mis à jour avec succés ");
            return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_azul/admin_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $this->addFlash('success', "L'utilisateur <strong>{$user->fullname()}</strong> a été supprimé avec succés ");
        
        return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
    }
     /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
         
        $this->addFlash('success', 'Votre email est verifié.');

        return $this->redirectToRoute('home');
    }
}
