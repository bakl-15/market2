<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
    
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( * min = 3, * max = 255, * minMessage = "Votre nom doit comporter au moins 5 caractères ", * maxMessage = "Votre nom ne peut pas dépasser 255 caractères " * )
     * @Assert\NotBlank(message="Ce champs  ne peut etre vide ")
   
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length( * min = 3, * max = 255, * minMessage = "Votre rue doit comporter au moins 5 caractères ", * maxMessage = "Votre rue ne peut pas dépasser 255 caractères " * )
     * @Assert\NotBlank(message="Ce champs  ne peut etre vide ")
     */
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $complement;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs  ne peut etre vide ")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs  ne peut etre vide ")
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champs  ne peut etre vide ")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs  ne peut etre vide ")
     * @Assert\Country(message="Ce champs  doit etre un pays ")
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="addresses")
     */
    private $user;

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

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
        /**
         * @ORM\PrePersist
         * @ORM\PreUpdate
         */
        public function setupdatedAtValue()
        {
            $this->updateddAt = new \DateTime();
        }
        /**
          * @ORM\PrePersist
         */
        public function setCreatedAtValue()
        {
            $this->createdAt = new \DateTime();
      
        }
       public function getUpdatedAt(): ?\DateTime
       {
           return $this->updatedAt;
       }

       public function setUpdatedAt(?\DateTime $updatedAt): self
       {
           $this->updatedAt = $updatedAt;

           return $this;
       }

       public function __toString()
       {
           $result = '[strong]' . $this->fullname  . '[/strong] : ';
           $result .= $this->address  . ' ';
           if($this->complement){
            $result .= '(' . $this->complement  . ') ';
           }
          
           $result .= $this->zipCode . ', ';
           $result .= $this->city  . ' -';
           $result .= $this->country  . ' ';
           return $result;
       }
}
