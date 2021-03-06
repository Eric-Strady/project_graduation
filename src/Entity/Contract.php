<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRepository")
 * @UniqueEntity("name")
 * @UniqueEntity("grower")
 * @Vich\Uploadable
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
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $starting_season_at;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $ending_season_at;

    /**
     * @Vich\UploadableField(mapping="contract_image", fileNameProperty="image_name") 
     * @Assert\Image(mimeTypes={"image/jpeg", "image/png"})
     * @var File
     */
    private $image_file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="contract", orphanRemoval=true)
     */
    private $products;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Grower", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $grower;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
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

    public function getImageFile(): ?File
    {
        return $this->image_file;
    }

    public function setImageFile(?File $image_file = null): self
    {
        $this->image_file = $image_file;
        if ($this->image_file instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(?string $image_name): self
    {
        $this->image_name = $image_name;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setContract($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getContract() === $this) {
                $product->setContract(null);
            }
        }

        return $this;
    }

    public function getGrower(): ?Grower
    {
        return $this->grower;
    }

    public function setGrower(?Grower $grower): self
    {
        $this->grower = $grower;

        return $this;
    }
}
