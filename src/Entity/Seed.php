<?php

namespace App\Entity;

use App\Repository\SeedRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SeedRepository::class)
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
     *      minMessage = "La  déscription doit comporter au moins {{limit}} caractères",
     *      maxMessage = "La déscription doit comporter plus de {{limit}} caractères",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ ne doit pas être vide")
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Le champ  Semi doit comporter au moins {{limit}} caractères",
     *      maxMessage = "Le champ Semi doit comporter au moins {{limit}} caractères",
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
}
