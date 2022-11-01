<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * use Symfony\Component\Validator\Constraints as Assert;
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email( * message = "L'e-mail '{{ value }}' n'est pas un e-mail valide. " * )
     * @Assert\Length( * min = 10, * max = 255, * minMessage = "Votre email doit comporter au moins 6 caractères ", * maxMessage = "Votre email ne peut pas dépasser 255 caractères " * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( * min = 8, * max = 655, * minMessage = "Votre sujet doit comporter au moins 8 caractères ", * maxMessage = "Votre mot de passe ne peut pas dépasser 255 caractères " * )
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length( * min = 25, * max = 11655, * minMessage = "Votre mot de passe doit comporter au moins 8 caractères ", * maxMessage = "Votre message ne peut pas dépasser 11655 caractères " * )
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
      /**
         * @ORM\PrePersist
         */
        public function setCreatedAtValue()
        {
            $this->createdAt = new \DateTime();
        }
        /**
         * @ORM\PrePersist
         * @ORM\PreUpdate
         */
        public function setUpdatedAtValue()
        {
            $this->updatedAt = new \DateTime();
        } 
        public function getConcisSlug(){
            return substr($this->content,0,50) . '...';
        }
}
