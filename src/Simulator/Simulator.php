<?php

namespace App\Simulator;

use App\Entity\FoodType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Simulator
{
    /**
     * @Assert\NotBlank
     * @Assert\Range(min = 1, max = 10)
     */
    private $nb_adult;

    /**
     * @Assert\NotBlank
     * @Assert\Range(min = 0, max = 10)
     */
    private $nb_child;

    /**
     * @Assert\NotBlank
     */
    private $food_type;

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

    public function getFoodType(): ?FoodType
    {
        return $this->food_type;
    }

    public function setFoodType(FoodType $food_type): self
    {
        $this->food_type = $food_type;

        return $this;
    }
}
