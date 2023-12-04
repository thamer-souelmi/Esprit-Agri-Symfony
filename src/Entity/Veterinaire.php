<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\VeterinaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeterinaireRepository::class)]
class Veterinaire
{ #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idvet;

    #[ORM\Column(length: 200)]
    private ?string $nomvet;

    #[ORM\Column(length: 200)]
    private ?string $prenomvet;

    #[ORM\Column(length: 200)]
    private ?string $adresscabinet;

    #[ORM\Column]
    private ?int $numtel;

    #[ORM\Column(length: 200)]
    private ?string $adressmail;

    #[ORM\Column(length: 200)]
    private ?string $specialite;

    public function getIdvet(): ?int
    {
        return $this->idvet;
    }

    public function getNomvet(): ?string
    {
        return $this->nomvet;
    }

    public function setNomvet(string $nomvet): static
    {
        $this->nomvet = $nomvet;

        return $this;
    }

    public function getPrenomvet(): ?string
    {
        return $this->prenomvet;
    }

    public function setPrenomvet(string $prenomvet): static
    {
        $this->prenomvet = $prenomvet;

        return $this;
    }

    public function getAdresscabinet(): ?string
    {
        return $this->adresscabinet;
    }

    public function setAdresscabinet(string $adresscabinet): static
    {
        $this->adresscabinet = $adresscabinet;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getAdressmail(): ?string
    {
        return $this->adressmail;
    }

    public function setAdressmail(string $adressmail): static
    {
        $this->adressmail = $adressmail;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }


}
