<?php


namespace   App\Service;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;
use App\Entity\User;
class FileUploader
{
    /**
     * @var string
     */
    private $targetDirectory;

     /**
     * @var string
     */
    private $targetAvatarDirectory;
     /**
     * @var string
     */
    private  $targetCategoryDirectory;

    public function __construct(
        $targetDirectory,
         $targetAvatarDirectory,
         $targetCategoryDirectory
          )
    {
        $this->targetDirectory = $targetDirectory;
        $this->targetAvatarDirectory = $targetAvatarDirectory;
        $this->targetCategoryDirectory = $targetCategoryDirectory;

    }

    /**
     * Upload file to directory
     * @param File $file
     * @param string|null $directory directory to upload
     * @return string
     */
    public function upload(File $file, ?string $directory = null): string
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        if ($directory !== null) {
            $file->move($directory, $fileName);
      
        } else {
            $file->move($this->getTargetDirectory(), $fileName);
        }

        return $fileName;
    }
     /**
     * Upload file to directory
     * @param File $file
     * @param string|null $directory directory to upload
     * @return string
     */
    public function uploadProductImage(?File $file, ?string $directory = null): string
    {
       
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        if ($directory !== null) {
            $file->move($directory, $fileName);
      
        } else {
            $file->move($this->getTargetDirectory(), $fileName);
        }

        return $fileName;
    }
     /**
     * Upload file to directory
     * @param File $file
     * @param string|null $directory directory to upload
     * @return string
     */
    public function uploadAvatar(File $file, User $user, ?string $directory = null): string
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        if ($directory !== null) {
            $file->move($directory, $fileName);
        } else {
            $file->move($this->getTargetAvatarDirectory(), $fileName);
        }
        $user->setCoverImage( '/' . $fileName);
        return $fileName;
    }
    /**
     * Get target directory
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
       /**
     * Get target  avatar directory
     * @return string
     */
    public function getTargetAvatarDirectory(): string
    {
        return $this->targetAvatarDirectory;
    }
      /**
     * Get target  category directory
     * @return string
     */
    public function getTargetCategoryDirectory(): string
    {
        return $this->targetCategoryDirectory;
    }
}
