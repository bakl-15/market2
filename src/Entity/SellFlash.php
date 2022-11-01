<?php

namespace App\Entity;

use App\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SellFlashRepository;

/**
 * @ORM\Entity(repositoryClass=SellFlashRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SellFlash
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, cascade={"persist", "remove"})
     */
    private $product;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?product
    {
        return $this->product;
    }

    public function setProduct(?product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
    /**
    * @ORM\PrePersist
    */
    public function setStartedAtValue()
    {
        $this->startedAt = new \DateTime();
    }

    public function getDiscount(): ?float
    {
        if($this->product->getCoupon() && $this->product->getCoupon()->getStatus() === "Activé"){
            if($this->product->getCoupon()->getType() ==="Pourcentage"){
               return  $this->product->getCoupon()->getDiscount();
            }
            if($this->product->getCoupon()->getType() ==="Montant fixe"){
               return  $this->product->getCoupon()->getDiscount();
            }
       }
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
