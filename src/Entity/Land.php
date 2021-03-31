<?php

namespace App\Entity;

use App\Repository\LandRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=LandRepository::class)
 * @Vich\Uploadable
 */
class Land
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
     *      minMessage = "La  déscription doit comporter au moins {{limit}} caractères",
     *      maxMessage = "La déscription doit comporter plus de {{limit}} caractères",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le champ ville* saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le champ adresse* saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(
     *     message="Le code postal est obligatoire"
     * )
     * @Assert\Length(
     *     max = 20,
     *     maxMessage = "Le code postal ne doit pas faire plus de {{ limit }} caractères",
     * )
     */

    private $zipCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
    private $slug;


  // ... other fields

  /**
   * NOTE: This is not a mapped field of entity metadata, just a simple property.
   *
   * @Vich\UploadableField(mapping="land_image", fileNameProperty="imageName",)
   *
   * @var File|null
   */
    private $imageFile;

  /**
   * @ORM\Column(type="string", nullable=true)
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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Users;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->Users;
    }

    public function setUsers(?User $Users): self
    {
        $this->Users = $Users;

        return $this;
    }
}
