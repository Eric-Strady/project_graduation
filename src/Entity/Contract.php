<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 */
class Contract
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
     * @ORM\Column(type="string", length=255)
     */
    private $grower_name;

    /**
     * @ORM\Column(type="text")
     */
    private $summary;

    /**
     * @ORM\Column(type="date")
     */
    private $starting_season_at;

    /**
     * @ORM\Column(type="date")
     */
    private $ending_season_at;

    /**
     * @ORM\Column(type="float")
     */
    private $grower_gps_lat;

    /**
     * @ORM\Column(type="float")
     */
    private $grower_gps_lng;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;


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

    public function getGrowerName(): ?string
    {
        return $this->grower_name;
    }

    public function setGrowerName(string $grower_name): self
    {
        $this->grower_name = $grower_name;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getStartingSeasonAt(): ?\DateTimeInterface
    {
        return $this->starting_season_at;
    }

    public function setStartingSeasonAt(?\DateTimeInterface $starting_season_at): self
    {
        $this->starting_season_at = $starting_season_at;

        return $this;
    }

    public function getEndingSeasonAt(): ?\DateTimeInterface
    {
        return $this->ending_season_at;
    }

    public function setEndingSeasonAt(?\DateTimeInterface $ending_season_at): self
    {
        $this->ending_season_at = $ending_season_at;

        return $this;
    }

    public function getGrowerGpsLat(): ?float
    {
        return $this->grower_gps_lat;
    }

    public function setGrowerGpsLat(float $grower_gps_lat): self
    {
        $this->grower_gps_lat = $grower_gps_lat;

        return $this;
    }

    public function getGrowerGpsLng(): ?float
    {
        return $this->grower_gps_lng;
    }

    public function setGrowerGpsLng(float $grower_gps_lng): self
    {
        $this->grower_gps_lng = $grower_gps_lng;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
