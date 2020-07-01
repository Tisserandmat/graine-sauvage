<?php

namespace App\Entity;

use App\Repository\VegeteableRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VegeteableRepository::class)
 */
class Vegetable
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
     *      minMessage = "La  déscription doit comporter au moins {{limit}} caractères",
     *      maxMessage = "La déscription doit comporter plus de {{limit}} caractères",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le champ nom saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $latinName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le champ nom saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le champ nom saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      max = 15,
     *      maxMessage = "Le champ nom saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $harvestMonth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 15,
     *      maxMessage = "Le champ nom saisie est trop long, il ne devrait pas dépasser {{ limit }} caractères",
     * )
     */
    private $soilType;

    /**
     * @ORM\OneToOne(targetEntity=Seed::class, inversedBy="vegeteable", cascade={"persist", "remove"})
     */
    private $seed;

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

    public function getLatinName(): ?string
    {
        return $this->latinName;
    }

    public function setLatinName(?string $latinName): self
    {
        $this->latinName = $latinName;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getHarvestMonth(): ?string
    {
        return $this->harvestMonth;
    }

    public function setHarvestMonth(string $harvestMonth): self
    {
        $this->harvestMonth = $harvestMonth;

        return $this;
    }

    public function getSoilType(): ?string
    {
        return $this->soilType;
    }

    public function setSoilType(?string $soilType): self
    {
        $this->soilType = $soilType;

        return $this;
    }

    public function getSeed(): ?Seed
    {
        return $this->seed;
    }

    public function setSeed(?Seed $seed): self
    {
        $this->seed = $seed;

        return $this;
    }
}
