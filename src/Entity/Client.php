<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idUser = null;


    #[ORM\Column]
    private ?int $prodid = null;


    #[Assert\NotBlank(message: 'veuillez remplir ce champ')]
    #[Assert\Length(min: 3, minMessage: 'Le libelle doit comporter au moins {{ limit }} caractères')]
    #[ORM\Column(length: 150)]
    private ?string $nomprod = null;


    #[Assert\NotBlank(message: 'Le prix du produit ne peut pas être vides.')]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'Le prix du produit ne peut pas être négatifs.'
    )]
    #[ORM\Column]
    private ?float $prix = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateajout = null;


    #[Assert\NotBlank(message: 'La quantite ne peut pas être vides.')]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'La quantite ne peut pas être négatifs.'
    )]
    #[ORM\Column]
    private ?float $qte = null;

    #[ORM\Column(length: 150)]
    private ?string $image = null;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getProdid(): ?int
    {
        return $this->prodid;
    }

    public function setProdid(int $prodid): static
    {
        $this->prodid = $prodid;

        return $this;
    }

    public function getNomprod(): ?string
    {
        return $this->nomprod;
    }

    public function setNomprod(string $nomprod): static
    {
        $this->nomprod = $nomprod;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateajout(): ?\DateTimeInterface
    {
        return $this->dateajout;
    }

    public function setDateajout(\DateTimeInterface $dateajout): static
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->qte;
    }

    public function setQte(float $qte): static
    {
        $this->qte = $qte;

        return $this;
    }
}
