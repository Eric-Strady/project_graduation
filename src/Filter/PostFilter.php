<?php

namespace App\Filter;

use Doctrine\Common\Collections\ArrayCollection;

class PostFilter
{
    /**
     * 
     */
    private $date;

    /**
     * 
     */
    private $post_categories;

    public function __construct()
    {
        $this->post_categories = new ArrayCollection();
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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
