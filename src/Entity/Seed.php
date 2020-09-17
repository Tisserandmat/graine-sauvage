<?php

namespace App\Entity;

use App\Repository\SeedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=SeedRepository::class)
 * @Vich\Uploadable
 */
class Seed
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le champ nom saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      min = 15,
     *      max = 65535,
     *      minMessage = "La  déscription doit comporter au moins 15 caractères",
     *      maxMessage = "La déscription ne doit pas comporter plus de 65535 caractères",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le champ  Semi doit comporter au moins 3 caractères",
     *      maxMessage = "Le champ Semi ne doit pas comporter plus de 255 caractères",
     * )
     */
    private $seeding;

    /**
     * @ORM\Column(type="integer")
     * a@Assert\NotBlank(message="Le champ ne doit pas être vide")
     */

    private $price;

    /**
     * @ORM\OneToOne(targetEntity=Vegetable::class, inversedBy="seed", cascade={"persist", "remove"})
     */
    private $vegetable;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="seed_image", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

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

    public function getSeeding(): ?string
    {
        return $this->seeding;
    }

    public function setSeeding(string $seeding): self
    {
        $this->seeding = $seeding;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVegetable(): ?Vegetable
    {
        return $this->vegetable;
    }

    public function setVegetable(?Vegetable $vegetable): self
    {
        $this->vegetable = $vegetable;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

}
