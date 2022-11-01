<?php

namespace App\Manager;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;
class Manager {

    /**
     * @var EntityManagerInterface $em
     */
    protected $em;
   
     /**
     * @var FileUploader $fileUploader
     */
    protected $fileUploader;
    
    /**
     * MeetingManager constructor.
     *
     * @param EntityManagerInterface $em
    
     * @param FileUploader $fileUploader
     */

    public function __construct(
        EntityManagerInterface $em,
        FileUploader $fileUploader
    )
    {
        $this->em = $em;
        $this->session = new Session();
        $this->fileUploader = $fileUploader;
    }



     /**
     * permit d'enregistrer une entité dans la base des données
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush(); 
    }
     /**
     * permit de creer  une nouvelle  entité dans la base des données
     */
    public function create($entity)
    {
        $this->save($entity);
    }
   /*
   * @param Request $request
   * @param Form $form
   * @param $entity
   * @param Array $data
   **/
    public function newBySubmitForm( Form $form,$entity,Request $request, $data): bool
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
    
            $this->create($entity);
            
            $request->getSession()->getFlashBag()->add(
                $data['type'],
                $data['message']
            );
             return true;
        }else{
            return false;
        }
   }

   /**
     * Remove l'entité
    */
    public function remove($entity, Request $request, $data): bool
    {
    
        $this->em->remove($entity);
        $this->em->flush();
        $request->getSession()->getFlashBag()->add(
            $data['type'],
            $data['message']
        );
        return true;
    }

    public Function addImage(){

    }

}