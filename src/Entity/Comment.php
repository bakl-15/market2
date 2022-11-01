<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qualityRating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceRating;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

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
        
        /**
        * @ORM\PrePersist
        * @ORM\PreUpdate
        */
       public function setRatingValue()
       {
           if($this->qualityRating && $this->priceRating){
             if($this->qualityRating > 0 || $this->priceRating > 0  ){
                $rating = ($this->qualityRating + $this->priceRating ) /2 ;
                $this->setRating($rating);
             }
           }else{
            $this->setRating(0);
           }
        
       }

        public function getQualityRating(): ?int
        {
            return $this->qualityRating;
        }

        public function setQualityRating(?int $qualityRating): self
        {
            $this->qualityRating = $qualityRating;

            return $this;
        }

        public function getPriceRating(): ?int
        {
            return $this->priceRating;
        }

        public function setPriceRating(?int $priceRating): self
        {
            $this->priceRating = $priceRating;

            return $this;
        }

        public function getConcisSlug(){
            return substr($this->content,0,50) . '...';
        }
}
