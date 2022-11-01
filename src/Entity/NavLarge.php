<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NavLargeRepository;
use Doctrine\Common\Collections\Collection;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=NavLargeRepository::class)
 * @UniqueEntity(fields={"name"}, message="Il y a déjà un large menu avec ce nom ")
 */
class NavLarge
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
     * @ORM\ManyToMany(targetEntity=CategoryParent::class, inversedBy="navLarges")
     */
    private $CatParente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ribbon;

    public function __construct()
    {
        $this->CatParente = new ArrayCollection();
    }

   


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

    /**
     * @return Collection|CategoryParent[]
     */
    public function getCatParente(): Collection
    {
        return $this->CatParente;
    }

    public function addCatParente(CategoryParent $catParente): self
    {
        if (!$this->CatParente->contains($catParente)) {
            $this->CatParente[] = $catParente;
        }

        return $this;
    }

    public function removeCatParente(CategoryParent $catParente): self
    {
        $this->CatParente->removeElement($catParente);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRibbon(): ?string
    {
        return $this->ribbon;
    }

    public function setRibbon(?string $ribbon): self
    {
        $this->ribbon = $ribbon;

        return $this;
    }

   

  

 
}
