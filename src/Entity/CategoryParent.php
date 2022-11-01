<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\CategoryParentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CategoryParentRepository::class)
 * @UniqueEntity(fields={"name"}, message="Cette catégorie, vous l'avez déja ajouté! veuillez l'éditer si vous voulez.  ")
 */
class CategoryParent
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="categoryParents")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=NavLarge::class, mappedBy="CatParente")
     */
    private $navLarges;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ribbon;

   
    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->navLarges = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
    public function __toString():string
    {
        return $this->getName();
    }

    /**
     * @return Collection|NavLarge[]
     */
    public function getNavLarges(): Collection
    {
        return $this->navLarges;
    }

    public function addNavLarge(NavLarge $navLarge): self
    {
        if (!$this->navLarges->contains($navLarge)) {
            $this->navLarges[] = $navLarge;
            $navLarge->addCatParente($this);
        }

        return $this;
    }

    public function removeNavLarge(NavLarge $navLarge): self
    {
        if ($this->navLarges->removeElement($navLarge)) {
            $navLarge->removeCatParente($this);
        }

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
