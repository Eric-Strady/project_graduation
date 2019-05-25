<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_fixed_delivery;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_delivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_fixed_price;

    /**
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $fixed_price;

    /**
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $min_price;

    /**
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="decimal", precision=5, scale=2, nullable=true)
     */
    private $max_price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contract", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contract;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\FoodType", inversedBy="products")
     */
    private $food_types;

    public function __construct()
    {
        $this->food_types = new ArrayCollection();
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

    public function getIsFixedDelivery(): ?bool
    {
        return $this->is_fixed_delivery;
    }

    public function setIsFixedDelivery(bool $is_fixed_delivery): self
    {
        $this->is_fixed_delivery = $is_fixed_delivery;

        return $this;
    }

    public function getNbDelivery(): ?int
    {
        return $this->nb_delivery;
    }

    public function setNbDelivery(?int $nb_delivery): self
    {
        $this->nb_delivery = $nb_delivery;

        return $this;
    }

    public function getIsFixedPrice(): ?bool
    {
        return $this->is_fixed_price;
    }

    public function setIsFixedPrice(bool $is_fixed_price): self
    {
        $this->is_fixed_price = $is_fixed_price;

        return $this;
    }

    public function getFixedPrice()
    {
        return $this->fixed_price;
    }

    public function setFixedPrice($fixed_price): self
    {
        $this->fixed_price = $fixed_price;

        return $this;
    }

    public function getMinPrice()
    {
        return $this->min_price;
    }

    public function setMinPrice($min_price): self
    {
        $this->min_price = $min_price;

        return $this;
    }

    public function getMaxPrice()
    {
        return $this->max_price;
    }

    public function setMaxPrice($max_price): self
    {
        $this->max_price = $max_price;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * @return Collection|FoodType[]
     */
    public function getFoodTypes(): Collection
    {
        return $this->food_types;
    }

    public function addFoodType(FoodType $foodType): self
    {
        if (!$this->food_types->contains($foodType)) {
            $this->food_types[] = $foodType;
        }

        return $this;
    }

    public function removeFoodType(FoodType $foodType): self
    {
        if ($this->food_types->contains($foodType)) {
            $this->food_types->removeElement($foodType);
        }

        return $this;
    }
}
