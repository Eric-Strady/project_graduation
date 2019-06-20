<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AboutRepository")
 */
class About
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private $how_join_us;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/\d+[,\.]{1}\d+/")
     * @ORM\Column(type="float")
     */
    private $amap_gps_lat;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/\d+[,\.]{1}\d+/")
     * @ORM\Column(type="float")
     */
    private $amap_gps_lng;

    /**
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="integer")
     */
    private $nb_members;

    /**
     * @Assert\GreaterThan(0)
     * @ORM\Column(type="integer")
     */
    private $annual_membership_fee;

    /**
     * @Assert\Length(max=255)
     * @Assert\Regex("#^(https?:\/\/)([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$#")
     * @ORM\Column(type="string", length=255)
     */
    private $facebook_link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHowJoinUs(): ?string
    {
        return $this->how_join_us;
    }

    public function setHowJoinUs(?string $how_join_us): self
    {
        $this->how_join_us = $how_join_us;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAmapGpsLat(): ?float
    {
        return $this->amap_gps_lat;
    }

    public function setAmapGpsLat(?float $amap_gps_lat): self
    {
        $this->amap_gps_lat = $amap_gps_lat;

        return $this;
    }

    public function getAmapGpsLng(): ?float
    {
        return $this->amap_gps_lng;
    }

    public function setAmapGpsLng(?float $amap_gps_lng): self
    {
        $this->amap_gps_lng = $amap_gps_lng;

        return $this;
    }

    public function getNbMembers(): ?int
    {
        return $this->nb_members;
    }

    public function setNbMembers(?int $nb_members): self
    {
        $this->nb_members = $nb_members;

        return $this;
    }

    public function getAnnualMembershipFee(): ?int
    {
        return $this->annual_membership_fee;
    }

    public function setAnnualMembershipFee(?int $annual_membership_fee): self
    {
        $this->annual_membership_fee = $annual_membership_fee;

        return $this;
    }

    public function getFacebookLink(): ?string
    {
        return $this->facebook_link;
    }

    public function setFacebookLink(?string $facebook_link): self
    {
        $this->facebook_link = $facebook_link;

        return $this;
    }
}
