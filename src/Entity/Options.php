<?php

namespace App\Entity;

use App\Repository\OptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionsRepository::class)
 */
class Options
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
    private $Money;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $langue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productsPerPage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numParentCategory;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoney(): ?string
    {
        return $this->Money;
    }

    public function setMoney(string $Money): self
    {
        $this->Money = $Money;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getProductsPerPage(): ?int
    {
        return $this->productsPerPage;
    }

    public function setProductsPerPage(?int $productsPerPage): self
    {
        $this->productsPerPage = $productsPerPage;

        return $this;
    }

    public function getNumParentCategory(): ?int
    {
        return $this->numParentCategory;
    }

    public function setNumParentCategory(?int $numParentCategory): self
    {
        $this->numParentCategory = $numParentCategory;

        return $this;
    }
}
