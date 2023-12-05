<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnoncerecrutementRepository;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;


use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: AnnoncerecrutementRepository::class)]
#[ORM\Table(name: "annoncerecrutement")]
class Annoncerecrutement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idRecrut")]
    private ?int $idRecrut = null;

    #[ORM\Column(length: 255)]
    private ?string $posteDemande = null;


    #[ORM\Column(precision: 10, scale: 0)]
    private ?float $salairePropose = null;

    #[ORM\Column(length: 0)]
    private ?string $typeContrat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePub = null;

    #[ORM\Column(length: 25)]
    private ?string $localisation = null;



     #[ORM\Column(nullable: true)]
    private ?\DateTimeInterface $dateEmbauche;


    #[ORM\Column()]
    private ?int $nbPosteRecherche;

    #[ORM\Column]

    private  ?bool $archived = false;

    #[ORM\OneToMany(mappedBy: "idannrecru", targetEntity: Candidature::class)]
    private Collection $candidatures;


    #[ORM\ManyToOne(targetEntity: User::class)]
#[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
private ?User $user;


    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

    public function getIdRecrut(): ?int
    {
        return $this->idRecrut;
    }

    public function getPosteDemande(): ?string
    {
        return $this->posteDemande;
    }

    public function setPosteDemande(string $posteDemande): static
    {
        $this->posteDemande = $posteDemande;

        return $this;
    }

    public function getSalairePropose(): ?float
    {
        return $this->salairePropose;
    }

    public function setSalairePropose(float $salairePropose): static
    {
        $this->salairePropose = $salairePropose;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(string $typeContrat): static
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->datePub;
    }

    public function setDatePub(\DateTimeInterface $datePub): static
    {
        $this->datePub = $datePub;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(\DateTimeInterface $dateEmbauche): static
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    public function getNbPosteRecherche(): ?int
    {
        return $this->nbPosteRecherche;
    }

    public function setNbPosteRecherche(int $nbPosteRecherche): static
    {
        $this->nbPosteRecherche = $nbPosteRecherche;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function isArchived(): bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    // public function addCandidature(Candidature $candidature): self
    // {
    //     if (!$this->candidatures->contains($candidature)) {
    //         $this->candidatures[] = $candidature;
    //         $candidature->setIdannrecru($this);
    //     }

    //     return $this;
    // }

    // public function removeCandidature(Candidature $candidature): self
    // {
    //     if ($this->candidatures->removeElement($candidature)) {
    //         // set the owning side to null (unless already changed)
    //         if ($candidature->getIdannrecru() === $this) {
    //             $candidature->setIdannrecru(null);
    //         }
    //     }

    //     return $this;
    // }

}
