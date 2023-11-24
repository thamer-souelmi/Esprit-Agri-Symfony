<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AnnonceinvestissementRepository;

#[ORM\Table(name: "annonceinvestissement")]
#[ORM\Entity(repositoryClass: AnnonceinvestissementRepository::class)]
class Annonceinvestissement
{
    #[ORM\Column(name: "idAnnonce", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private int $idannonce;

    #[ORM\Column(name: "titre", type: "string", length: 200, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter le titre !")]
    private string $titre;

    #[ORM\Column(name: "montant", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter le montant !")]
    private float $montant;

    #[ORM\Column(name: "datePublication", type: "date", nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter la date de publication !")]
    #[Assert\GreaterThanOrEqual("today", message: "La date de publication ne peut pas être antérieure à aujourd'hui")]
    private \DateTimeInterface $datepublication;

    #[ORM\Column(name: "localisation", type: "string", length: 100, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter la localisation !")]
    private string $localisation;

    #[ORM\Column(name: "description", type: "string", length: 400, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter la description !")]
    private string $description;

    #[ORM\Column(name: "photo", type: "string", length: 500, nullable: false)]
    private string $photo;

    public function getIdannonce(): ?int
    {
        return $this->idannonce;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDatepublication(): ?\DateTimeInterface
    {
        return $this->datepublication;
    }

    public function setDatepublication(\DateTimeInterface $datepublication): self
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}