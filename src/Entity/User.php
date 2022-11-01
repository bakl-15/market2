<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Service\IpService;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il y a déjà un compte avec cet email ")
 * @ORM\HasLifecycleCallbacks()
 * use Symfony\Component\Validator\Constraints as Assert;
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     
     * @Assert\Email( * message = "L'e-mail '{{ value }}' n'est pas un e-mail valide. " * )
     * @Assert\Length( * min = 10, * max = 255, * minMessage = "Votre email doit comporter au moins 6 caractères ", * maxMessage = "Votre email ne peut pas dépasser 255 caractères " * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
    
     * @Assert\Length( * min = 8, * max = 655, * minMessage = "Votre mot de passe doit comporter au moins 8 caractères ", * maxMessage = "Votre mot de passe ne peut pas dépasser 255 caractères " * )
     */
    private $password;

   

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champs email ne peut etre vide, veuillez entrer ton email ")
     * @Assert\Length( * min = 3, * max = 255, * minMessage = "Votre prénom doit comporter au moins 3 caractères ", * maxMessage = "Votre prénom ne peut pas dépasser 255 caractères " * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champs email ne peut etre vide, veuillez entrer ton email ")
     * @Assert\Length( * min = 3, * max = 255, * minMessage = "Votre nom doit comporter au moins 3 caractères ", * maxMessage = "Votre prénom ne peut pas dépasser 255 caractères " * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
  
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ipAdress;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="user")
     */
    private $addresses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=ReviewsProducts::class, mappedBy="user")
     */
    private $reviewsProducts;

    /**
     * @ORM\ManyToMany(targetEntity=Role::class, mappedBy="user")
     */
    private $userRoles;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="user")
     */
    private $orders;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="users")
     */
    private $Favorites;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->reviewsProducts = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->Favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->userRoles->map(function($role){
          return  $role->getTitle();
        })->toArray();
      
        $roles[] = 'ROLE_USER';

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIpAdress(): ?string
    {
        return $this->ipAdress;
    }

    public function setIpAdress(?string $ipAdress): self
    {
        $this->ipAdress = $ipAdress;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
   
     /**
     * @ORM\PrePersist
     */
        public function setUserValue()
        {
            if( ! $this->username){
                $this->username = '@Azul-' . $this->fullname();
            }
        } 

        public function fullname(){
           return $this->lastname . ' ' . $this->firstname;
        }

        /**
         * @return Collection|Address[]
         */
        public function getAddresses(): Collection
        {
            return $this->addresses;
        }

        public function addAddress(Address $address): self
        {
            if (!$this->addresses->contains($address)) {
                $this->addresses[] = $address;
                $address->setUser($this);
            }

            return $this;
        }

        public function removeAddress(Address $address): self
        {
            if ($this->addresses->removeElement($address)) {
                // set the owning side to null (unless already changed)
                if ($address->getUser() === $this) {
                    $address->setUser(null);
                }
            }

            return $this;
        }
        
        public function __toString(){
            return $this->firstname;
        }

        public function getCoverImage(): ?string
        {
            return $this->coverImage;
        }

        public function setCoverImage(?string $coverImage): self
        {
            $this->coverImage = $coverImage;

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
                $reviewsProduct->setUser($this);
            }

            return $this;
        }

        public function removeReviewsProduct(ReviewsProducts $reviewsProduct): self
        {
            if ($this->reviewsProducts->removeElement($reviewsProduct)) {
                // set the owning side to null (unless already changed)
                if ($reviewsProduct->getUser() === $this) {
                    $reviewsProduct->setUser(null);
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
         /**
         * @ORM\PrePersist
         */
        public function setIpAddressValue()
        {
            $ipService = new IpService();
            $this->ipAdress = $ipService->getIp();
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
         * @return Collection|Role[]
         */
        public function getUserRoles(): Collection
        {
            return $this->userRoles;
        }

        public function addUserRole(Role $userRole): self
        {
            if (!$this->userRoles->contains($userRole)) {
                $this->userRoles[] = $userRole;
                $userRole->addUser($this);
            }

            return $this;
        }

        public function removeUserRole(Role $userRole): self
        {
            if ($this->userRoles->removeElement($userRole)) {
                $userRole->removeUser($this);
            }

            return $this;
        }

        /**
         * @return Collection|Order[]
         */
        public function getOrders(): Collection
        {
            return $this->orders;
        }

        public function addOrder(Order $order): self
        {
            if (!$this->orders->contains($order)) {
                $this->orders[] = $order;
                $order->setUser($this);
            }

            return $this;
        }

        public function removeOrder(Order $order): self
        {
            if ($this->orders->removeElement($order)) {
                // set the owning side to null (unless already changed)
                if ($order->getUser() === $this) {
                    $order->setUser(null);
                }
            }

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
                $comment->setAuthor($this);
            }

            return $this;
        }

        public function removeComment(Comment $comment): self
        {
            if ($this->comments->removeElement($comment)) {
                // set the owning side to null (unless already changed)
                if ($comment->getAuthor() === $this) {
                    $comment->setAuthor(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection|Product[]
         */
        public function getFavorites(): Collection
        {
            return $this->Favorites;
        }

        public function addFavorite(Product $favorite): self
        {
            if (!$this->Favorites->contains($favorite)) {
                $this->Favorites[] = $favorite;
            }

            return $this;
        }

        public function removeFavorite(Product $favorite): self
        {
            $this->Favorites->removeElement($favorite);

            return $this;
        }

     
}
