<?php

namespace App\Entity;
use App\Repository\TraitementmedicaleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraitementmedicaleRepository::class)]

class Traitementmedicale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 11)]
    private ?string$numero;

    #[ORM\Column(length: 0)]
    private ?string $typeintervmed;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateintervmed;

    #[ORM\Column]
    private ?float $coutinterv;

    #[ORM\Column(length: 200)]
    private ?string $medicament;

    #[ORM\Column(length: 200)]
    private ?string $dureetraitement;

    #[ORM\Column(length: 200)]
    private ?string $description;

    #[ORM\ManyToOne(inversedBy: 'vets')]
    private ?Veterinaire $idvet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTypeintervmed(): ?string
    {
        return $this->typeintervmed;
    }

    public function setTypeintervmed(string $typeintervmed): static
    {
        $this->typeintervmed = $typeintervmed;

        return $this;
    }

    public function getDateintervmed(): ?\DateTimeInterface
    {
        return $this->dateintervmed;
    }

    public function setDateintervmed(\DateTimeInterface $dateintervmed): static
    {
        $this->dateintervmed = $dateintervmed;

        return $this;
    }

    public function getCoutinterv(): ?float
    {
        return $this->coutinterv;
    }

    public function setCoutinterv(float $coutinterv): static
    {
        $this->coutinterv = $coutinterv;

        return $this;
    }

    public function getMedicament(): ?string
    {
        return $this->medicament;
    }

    public function setMedicament(string $medicament): static
    {
        $this->medicament = $medicament;

        return $this;
    }

    public function getDureetraitement(): ?string
    {
        return $this->dureetraitement;
    }

    public function setDureetraitement(string $dureetraitement): static
    {
        $this->dureetraitement = $dureetraitement;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIdvet(): ?Veterinaire
    {
        return $this->idvet;
    }

    public function setIdvet(?Veterinaire $idvet): static
    {
        $this->idvet = $idvet;

        return $this;
    }


}
