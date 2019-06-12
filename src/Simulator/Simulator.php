<?php

namespace App\Simulator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Simulator
{
    /**
     * @Assert\NotBlank
     */
    private $nb_adult;

    /**
     * @Assert\NotBlank
     */
    private $nb_child;

    /**
     * @Assert\NotBlank
     */
    private $total_price;

    /**
     * @Assert\NotBlank
     */
    private $food_type;

    private $products = [];

    public function getNbAdult(): ?int
    {
        return $this->nb_adult;
    }

    public function setNbAdult(int $nb_adult): self
    {
        $this->nb_adult = $nb_adult;

        return $this;
    }

    public function getNbChild(): ?int
    {
        return $this->nb_child;
    }

    public function setNbChild(int $nb_child): self
    {
        $this->nb_child = $nb_child;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->total_price;
    }

    public function setTotalPrice(int $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getFoodType(): ?FoodType
    {
        return $this->food_type;
    }

    public function setFoodType(FoodType $food_type): self
    {
        $this->food_type = $food_type;

        return $this;
    }

    public function getProducts(): ?array
    {
        return $this->products;
    }

    public function setProducts(array $products): self
    {
        $this->products = $products;

        return $this;
    }
}
