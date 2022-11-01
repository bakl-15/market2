<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @UniqueEntity(fields={"name"}, message="Cette catégorie, vous l'avez déja ajouté! veuillez l'éditer si vous voulez.  ")
 */
class Category
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, mappedBy="category", cascade={"persist"})
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=CategoryParent::class, mappedBy="category")
     */
    private $categoryParents;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ribbon;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->categoryParents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|CategoryParent[]
     */
    public function getCategoryParents(): Collection
    {
        return $this->categoryParents;
    }

    public function addCategoryParent(CategoryParent $categoryParent): self
    {
        if (!$this->categoryParents->contains($categoryParent)) {
            $this->categoryParents[] = $categoryParent;
            $categoryParent->addCategory($this);
        }

        return $this;
    }

    public function removeCategoryParent(CategoryParent $categoryParent): self
    {
        if ($this->categoryParents->removeElement($categoryParent)) {
            $categoryParent->removeCategory($this);
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
