<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GrowerRepository")
 * @UniqueEntity("name")
 */
class Grower
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
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^\d{5}$/")
     * @ORM\Column(type="string", length=6)
     */
    private $postal_code;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/\d+[,\.]{1}\d+/")
     * @ORM\Column(type="float")
     */
    private $gps_lat;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/\d+[,\.]{1}\d+/")
     * @ORM\Column(type="float")
     */
    private $gps_lng;

    /**
     * @Assert\Email
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @Assert\Length(max=255)
     * @Assert\Regex("#^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?\#[\]@!\$&'\(\)\*\+,;=.]+$#")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @Assert\Regex("#^0[1-9]([-. ]?[0-9]{2}){4}$#")
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phone;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getGpsLat(): ?float
    {
        return $this->gps_lat;
    }

    public function setGpsLat(float $gps_lat): self
    {
        $this->gps_lat = $gps_lat;

        return $this;
    }

    public function getGpsLng(): ?float
    {
        return $this->gps_lng;
    }

    public function setGpsLng(float $gps_lng): self
    {
        $this->gps_lng = $gps_lng;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
