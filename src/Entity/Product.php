<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @Assert\Type("bool")
     * @ORM\Column(type="boolean")
     */
    private $is_variable_delivery;

    /**
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_delivery;

    /**
     * @Assert\Type("bool")
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
     * @ORM\JoinColumn(nullable=false)
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

    public function getIsVariableDelivery(): ?bool
    {
        return $this->is_variable_delivery;
    }

    public function setIsVariableDelivery(bool $is_variable_delivery): self
    {
        $this->is_variable_delivery = $is_variable_delivery;

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

    /**
     * @Assert\Callback
     */
    public function checkDelivery(ExecutionContextInterface $context) {
        if ($this->getNbDelivery() && !$this->getIsVariableDelivery()) {
            $message = 'Vous ne pouvez pas attribuer un nombre de livraison, alors que le client n\'a pas le choix.';
            $path = 'nb_delivery';
            $this->addViolation($message, $path, $context);
        }
        elseif (!$this->getNbDelivery() && $this->getIsVariableDelivery()) {
            $message = 'Vous devez indiqué un nombre de livraison maximum, car le client a le choix.';
            $path = 'nb_delivery';
            $this->addViolation($message, $path, $context);
        }
    }

    /**
     * @Assert\Callback
     */
    public function checkFixedPrice(ExecutionContextInterface $context) {
        if ($this->getFixedPrice() && !$this->getIsFixedPrice()) {
            $message = 'Vous ne pouvez pas attribuer un prix fixe, alors que celui-ci est variable.';
            $path = 'fixed_price';
            $this->addViolation($message, $path, $context);
        }
        elseif (!$this->getFixedPrice() && $this->getIsFixedPrice()) {
            $message = 'Vous devez indiquer un prix fixe.';
            $path = 'fixed_price';
            $this->addViolation($message, $path, $context);
        }
    }

    /**
     * @Assert\Callback
     */
    public function checkMinPrice(ExecutionContextInterface $context) {
        if ($this->getMinPrice() && $this->getIsFixedPrice()) {
            $message = 'Vous ne pouvez pas attribuer un prix minimum, alors que celui-ci est fixe.';
            $path = 'min_price';
            $this->addViolation($message, $path, $context);
        }
        elseif (!$this->getMinPrice() && !$this->getIsFixedPrice()) {
            $message = 'Vous devez indiquer un prix minimum, car celui-ci n\'est pas fixe.';
            $path = 'min_price';
            $this->addViolation($message, $path, $context);
        }
    }

    /**
     * @Assert\Callback
     */
    public function checkMaxPrice(ExecutionContextInterface $context) {
        if ($this->getMaxPrice() && $this->getIsFixedPrice()) {
            $message = 'Vous ne pouvez pas attribuer un prix maximum, alors que celui-ci est fixe.';
            $path = 'max_price';
            $this->addViolation($message, $path, $context);
        }
        elseif (!$this->getMaxPrice() && !$this->getIsFixedPrice()) {
            $message = 'Vous devez indiquer un prix maximum, car celui-ci n\'est pas fixe.';
            $path = 'max_price';
            $this->addViolation($message, $path, $context);
        }
    }

    private function addViolation($message, $path, $context) {
        $context->buildViolation($message)
            ->atPath($path)
            ->addViolation();
    }
}
