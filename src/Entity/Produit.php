<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit
{
    

/**
 * @var int
 *
 * @ORM\Column(name="id", type="integer", nullable=false)
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="IDENTITY")
 */
private $id;

/**
 * @var string
 *
 * @ORM\Column(name="Nomprod", type="string", length=30, nullable=false)
 * @Assert\NotBlank(message="Le nom du produit ne peut pas être vide.")
 * @Assert\Length(max=30, maxMessage="Le nom du produit ne peut pas dépasser {{ limit }} caractères.")
 */
private $nomprod;

/**
 * @var string
 *
 */
private $cat;

/**
 * @var float
 *
 * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
 * @Assert\NotBlank(message="Le prix ne peut pas être vide.")
 * @Assert\GreaterThan(value=0, message="Le prix doit être supérieur à zéro.")
 */
private $prix;

/**
 * @var float
 *
 * @ORM\Column(name="qte", type="float", precision=10, scale=0, nullable=false)
 * @Assert\NotBlank(message="La quantité ne peut pas être vide.")
 * @Assert\GreaterThan(value=0, message="La quantité doit être supérieure à zéro.")
 */
private $qte;

/**
 * @var string
 *
 * @ORM\Column(name="descr", type="string", nullable=false)
 * @Assert\NotBlank(message="La description ne peut pas être vide.")
 */
private $descr;

/**
 * @var bool
 *
 * @ORM\Column(name="status", type="boolean", nullable=false)
 */
private $status;

/**
 * @var string|null
 *
 * @ORM\Column(name="image", type="string", length=255, nullable=true)
 */
private $image;


    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): static
    {
        $this->cat = $cat;

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

    public function getQte(): ?float
    {
        return $this->qte;
    }

    public function setQte(float $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): static
    {
        $this->descr = $descr;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

   
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
