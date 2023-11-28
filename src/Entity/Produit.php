<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: '`produit`')]
class Produit
{
    

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nom du produit ne peut pas être vide.")]
    #[Assert\Length(max: 30, maxMessage: "Le nom du produit ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $nomprod = null;

    #[ORM\Column]
    private ?string $cat = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le prix ne peut pas être vide.")]
    #[Assert\GreaterThan(value: 0, message: "Le prix doit être supérieur à zéro.")]
    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La quantité ne peut pas être vide.")]
    #[Assert\GreaterThan(value: 0, message: "La quantité doit être supérieure à zéro.")]
    private ?float $qte = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La description ne peut pas être vide.")]
    private ?string $descr = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column]
    private ?string $image = null;


    
#[ORM\ManyToOne(targetEntity: "App\Entity\User", inversedBy: "produits")]
#[ORM\JoinColumn(nullable: false)]
private ?User $user = null;

#[ORM\OneToMany(mappedBy: 'produit', targetEntity: Reclamation::class)]
private Collection $reclamations;

public function __construct()
{
    $this->reclamations = new ArrayCollection();
}

// #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Reclamation::class)]
// private Collection $reclamations;

// public function __construct()
// {
//     $this->reclamations = new ArrayCollection();
// }


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

    // /**
    //  * @return Collection<int, Reclamation>
    //  */
    // public function getReclamations(): Collection
    // {
    //     return $this->reclamations;
    // }

    // public function addReclamation(Reclamation $reclamation): static
    // {
    //     if (!$this->reclamations->contains($reclamation)) {
    //         $this->reclamations->add($reclamation);
    //         $reclamation->setProduit($this);
    //     }

    //     return $this;
    // }

    // public function removeReclamation(Reclamation $reclamation): static
    // {
    //     if ($this->reclamations->removeElement($reclamation)) {
    //         // set the owning side to null (unless already changed)
    //         if ($reclamation->getProduit() === $this) {
    //             $reclamation->setProduit(null);
    //         }
    //     }

    //     return $this;
    // }
    public function getUserId(): ?int
{
    return $this->user ? $this->user->getId() : null;
}

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setProduit($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getProduit() === $this) {
                $reclamation->setProduit(null);
            }
        }

        return $this;
    }

  




}
