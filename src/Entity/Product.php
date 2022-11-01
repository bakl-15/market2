<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity(fields={"name"}, message="Ce produit, vous l'avez déja ajouté! veuillez l'éditer si vous voulez.  ")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $moreInformations;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBestSeller = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isNewArrival = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEcolo = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isFeatured = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSpecialOffer = false;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="product", cascade={"persist", "remove"})
     */
    private $images;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class, mappedBy="product")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=RelatedProduct::class, mappedBy="product")
     */
    private $relatedProducts;

    /**
     * @ORM\OneToMany(targetEntity=ReviewsProducts::class, mappedBy="product")
     */
    private $reviewsProducts;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNew;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="product", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Favorites")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ribbon;

    /**
     * @ORM\ManyToOne(targetEntity=Coupon::class, inversedBy="Products")
     */
    private $coupon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $promo;
  

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->relatedProducts = new ArrayCollection();
        $this->reviewsProducts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreInformations(): ?string
    {
        return $this->moreInformations;
    }

    public function setMoreInformations(?string $moreInformations): self
    {
        $this->moreInformations = $moreInformations;

        return $this;
    }

    public function getPrice(): ?float
    {
        if($this->coupon && $this->coupon->getStatus() === "Activé"){
             if($this->coupon->getType() ==="Pourcentage"){
                return $this->price -  (($this->price * $this->coupon->getDiscount())/100) ;
             }
             if($this->coupon->getType() ==="Montant fixe"){
                return $this->coupon->getDiscount() ;
             }
        }
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsBestSeller(): ?bool
    {
        return $this->isBestSeller;
    }

    public function setIsBestSeller(bool $isBestSeller): self
    {
        $this->isBestSeller = $isBestSeller;

        return $this;
    }

    public function getIsNewArrival(): ?bool
    {
        return $this->isNewArrival;
    }

    public function setIsNewArrival(?bool $isNewArrival): self
    {
        $this->isNewArrival = $isNewArrival;

        return $this;
    }

    public function getIsEcolo(): ?bool
    {
        return $this->isEcolo;
    }

    public function setIsEcolo(bool $isEcolo): self
    {
        $this->isEcolo = $isEcolo;

        return $this;
    }

    public function getIsFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(?bool $isFeatured): self
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }

    public function getIsSpecialOffer(): ?bool
    {
        return $this->isSpecialOffer;
    }

    public function setIsSpecialOffer(?bool $isSpecialOffer): self
    {
        $this->isSpecialOffer = $isSpecialOffer;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages() 
    {
         if(count($this->images) > 0 ){
            return $this->images;
         }
         return [];
    } 

    public function addImage(Image $image): self
    {
        if (! in_array($image, $this->images->toArray()) ) {
            $this->images[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

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

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addProduct($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|RelatedProduct[]
     */
    public function getRelatedProducts(): Collection
    {
        return $this->relatedProducts;
    }

    public function addRelatedProduct(RelatedProduct $relatedProduct): self
    {
        if (!$this->relatedProducts->contains($relatedProduct)) {
            $this->relatedProducts[] = $relatedProduct;
            $relatedProduct->setProduct($this);
        }

        return $this;
    }

    public function removeRelatedProduct(RelatedProduct $relatedProduct): self
    {
        if ($this->relatedProducts->removeElement($relatedProduct)) {
            // set the owning side to null (unless already changed)
            if ($relatedProduct->getProduct() === $this) {
                $relatedProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ReviewsProducts[]
     */
    public function getReviewsProducts(): Collection
    {
        return $this->reviewsProducts;
    }

    public function addReviewsProduct(ReviewsProducts $reviewsProduct): self
    {
        if (!$this->reviewsProducts->contains($reviewsProduct)) {
            $this->reviewsProducts[] = $reviewsProduct;
            $reviewsProduct->setProduct($this);
        }

        return $this;
    }

    public function removeReviewsProduct(ReviewsProducts $reviewsProduct): self
    {
        if ($this->reviewsProducts->removeElement($reviewsProduct)) {
            // set the owning side to null (unless already changed)
            if ($reviewsProduct->getProduct() === $this) {
                $reviewsProduct->setProduct(null);
            }
        }

        return $this;
    }
         /**
         * @ORM\PrePersist
         */
        public function setCreatedAtValue()
        {
            $this->createdAt = new \DateTime();
        }
        public function ressetImages(){
            $this->images =[];
        }

        public function __toString()
        {
            return $this->name;
        }

        public function getIsNew(): ?bool
        {
            return $this->isNew;
        }

        public function setIsNew(bool $isNew): self
        {
            $this->isNew = $isNew;

            return $this;
        }
        
        public function getMainImage(){
            foreach($this->images as $key => $image){
                if($key = 0 ){
                    return $image;
                }
            }
        }
       
       public function getUrl(){
           return $this->name . '-' . $this->id;
       }

       /**
        * @return Collection|Comment[]
        */
       public function getComments(): Collection
       {
           return $this->comments;
       }

       public function addComment(Comment $comment): self
       {
           if (!$this->comments->contains($comment)) {
               $this->comments[] = $comment;
               $comment->setProduct($this);
           }

           return $this;
       }

       public function removeComment(Comment $comment): self
       {
           if ($this->comments->removeElement($comment)) {
               // set the owning side to null (unless already changed)
               if ($comment->getProduct() === $this) {
                   $comment->setProduct(null);
               }
           }

           return $this;
       }

       public function getAvgRating(){
           $sum = array_reduce($this->comments->toArray(), function($total, $comment){
              return $total + $comment->getRating();
           },0);

           if(count($this->comments) >0){
               return $sum / count($this->comments);
           }
       }

       public function getAbstractDescription(){
           return substr($this->description,0, 100) . '...';
       }

       public function getQuantity(): ?int
       {
           return $this->quantity;
       }

       public function setQuantity(?int $quantity): self
       {
           $this->quantity = $quantity;

           return $this;
       }
       public function getConcisSlug(){
        return substr($this->description,0,50) . '...';
    }
    public function getFirstImage(){
        foreach($this->images as $key => $image){
           if($key === 0){
               return $image->getUrl();
           }
        }
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavorite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavorite($this);
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

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(?bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
    public function getOldPrice(): ?float
    {
        return $this->price;
    }
   /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
 public function setPromoValue()
  {
    if($this->coupon && $this->coupon->getStatus() === "Activé"){
      $this->promo = true;
   }
  }
}
