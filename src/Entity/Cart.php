<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 * @ORM\Table(name="`Cart`")
 * @ORM\HasLifecycleCallbacks()
 */
class Cart
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
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carrierName;

    /**
     * @ORM\Column(type="float")
     */
    private $carrierPrice;

    /**
     * @ORM\Column(type="text")
     */
    private $delevryAddress;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPaid = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $moreInformation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=CartDetail::class, mappedBy="Carts" , cascade={"persist", "remove"})
     */
    private $CartDetails;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Carts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $subTotalHT;

    /**
     * @ORM\Column(type="float")
     */
    private $taxe;

    /**
     * @ORM\Column(type="float")
     */
    private $subTotalTTC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

   /***************************************************************** */

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delevryCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delevryCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delevryZipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $delevryCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DelevryPhone;

   /***************************************************************** */
    public function __construct()
    {
        $this->CartDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
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

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?float
    {
        return $this->carrierPrice*100;
    }

    public function setCarrierPrice(float $carrierPrice): self
    {
        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelevryAddress(): ?string
    {
        return $this->delevryAddress;
    }

    public function setDelevryAddress(string $deleveryAddress): self
    {
        $this->delevryAddress = $deleveryAddress;

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getMoreInformation(): ?string
    {
        return $this->moreInformation;
    }

    public function setMoreInformation(?string $moreInformation): self
    {
        $this->moreInformation = $moreInformation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|CartDetail[]
     */
    public function getCartDetails(): Collection
    {
        return $this->CartDetails;
    }

    public function addCartDetail(CartDetail $CartDetail): self
    {
        if (!$this->CartDetails->contains($CartDetail)) {
            $this->CartDetails[] = $CartDetail;
            $CartDetail->setCarts($this);
        }

        return $this;
    }

    public function removeCartDetail(CartDetail $CartDetail): self
    {
        if ($this->CartDetails->removeElement($CartDetail)) {
            // set the owning side to null (unless already changed)
            if ($CartDetail->getCarts() === $this) {
                $CartDetail->setCarts(null);
            }
        }

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getsubTotalHT(): ?float
    {
        return $this->subTotalHT*100;
    }

    public function setsubTotalHT(float $subTotalHT): self
    {
        $this->subTotalHT = $subTotalHT;

        return $this;
    }

    public function getTaxe(): ?float
    {
        return $this->taxe*100;
    }

    public function setTaxe(float $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getSubTotalTTC(): ?float
    {
        return $this->subTotalTTC*100;
    }

    public function setSubTotalTTC(float $subTotalTTC): self
    {
        $this->subTotalTTC = $subTotalTTC;

        return $this;
    }
    /**
    * @ORM\PrePersist
    */
    public function setIsPaidValue()
    {
        $this->isPaid = false;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
    
    public function getDelevryCity(): ?string
    {
        return $this->delevryCity;
    }

    public function setDelevryCity(?string $delevryCity): self
    {
        $this->delevryCity = $delevryCity;

        return $this;
    }

    public function getDelevryCountry(): ?string
    {
        return $this->delevryCountry;
    }

    public function setDelevryCountry(?string $delevryCountry): self
    {
        $this->delevryCountry = $delevryCountry;

        return $this;
    }

    public function getDelevryZipCode(): ?string
    {
        return $this->delevryZipCode;
    }

    public function setDelevryZipCode(?string $delevryZipCode): self
    {
        $this->delevryZipCode = $delevryZipCode;

        return $this;
    }

    public function getDelevryCompany(): ?string
    {
        return $this->delevryCompany;
    }

    public function setDelevryCompany(?string $delevryCompany): self
    {
        $this->delevryCompany = $delevryCompany;

        return $this;
    }

    public function getDelevryPhone(): ?string
    {
        return $this->DelevryPhone;
    }

    public function setDelevryPhone(?string $DelevryPhone): self
    {
        $this->DelevryPhone = $DelevryPhone;

        return $this;
    }
}
