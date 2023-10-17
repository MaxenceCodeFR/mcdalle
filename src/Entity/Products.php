<?php

namespace App\Entity;

use App\Entity\Allergens;
use App\Entity\OrdersDetails;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom du produit est obligatoire')]
    #[Assert\Length(
        min: 6,
        max: 25,
        minMessage: 'Le nom du produit doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le nom du produit ne doit pas dépasser {{ limit }} caractères'
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $images = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le prix du produit est obligatoire')]
    //Positive ou PositiveOrZero permet de vérifier que le prix est bien positif
    //Je ne l'utilise pas ici car il est déjà défini dans "src/Form/ProductsFormType.php"
    //Mais il est possible de faire une contrainte ici aussi
    // #[Assert\Positive(message: 'Le prix du produit doit être positif')]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Categories $categories_id = null;

    #[ORM\ManyToMany(targetEntity: Allergens::class, inversedBy: 'products')]
    private Collection $allergens;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: OrdersDetails::class)]
    private Collection $ordersDetails;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
        $this->ordersDetails = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }


    public function getCategoriesId(): ?Categories
    {
        return $this->categories_id;
    }

    public function setCategoriesId(?Categories $categories_id): static
    {
        $this->categories_id = $categories_id;

        return $this;
    }

    /**
     * @return Collection<int, Allergens>
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergens $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
        }

        return $this;
    }

    public function removeAllergen(Allergens $allergen): static
    {
        $this->allergens->removeElement($allergen);

        return $this;
    }

    /**
     * @return Collection<int, OrdersDetails>
     */
    public function getOrdersDetails(): Collection
    {
        return $this->ordersDetails;
    }

    public function addOrdersDetail(OrdersDetails $ordersDetail): static
    {
        if (!$this->ordersDetails->contains($ordersDetail)) {
            $this->ordersDetails->add($ordersDetail);
            $ordersDetail->setProducts($this);
        }

        return $this;
    }

    public function removeOrdersDetail(OrdersDetails $ordersDetail): static
    {
        if ($this->ordersDetails->removeElement($ordersDetail)) {
            // set the owning side to null (unless already changed)
            if ($ordersDetail->getProducts() === $this) {
                $ordersDetail->setProducts(null);
            }
        }

        return $this;
    }
}
