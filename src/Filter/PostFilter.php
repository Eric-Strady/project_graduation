<?php

namespace App\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PostFilter
{
    /**
     * @Assert\Regex("/^2\d{3}$/")
     */
    private $year;

    private $post_categories;

    public function __construct()
    {
        $this->post_categories = new ArrayCollection();
    }

    public function getYear(): ?String
    {
        return $this->year;
    }

    public function setYear(?String $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPostCategories(): ArrayCollection
    {
        return $this->post_categories;
    }

    public function setPostCategories(ArrayCollection $post_categories): self
    {
        return $this->post_categories = $post_categories;
    }
}
