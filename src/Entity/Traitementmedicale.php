<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Traitementmedicale
 *
 * @ORM\Table(name="traitementmedicale")
 * @ORM\Entity
 */
class Traitementmedicale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 11)]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du numero')]
    #[Assert\Regex(
            pattern:"/^\d+$/",
            message:'Le numéro doit être composé uniquement de chiffres')]
    private ?string$numero;

    #[ORM\Column(length: 200)]
    private ?string $typeintervmed ='Vaccination';

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de commande ne peut pas être vide')]
    #[Assert\GreaterThanOrEqual(
        "today",
        message: 'La date de traitement ne peut pas être antérieure à aujourd\'hui'
    )]
    private ?\DateTimeInterface $dateintervmed =null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du cout')]
    #[Assert\Type(type: 'numeric', message: 'Le champ du cout doit être un nombre.')]
    private ?float $coutinterv;

    #[ORM\Column(length: 200)]
    private ?string $medicament;

    #[ORM\Column(length: 200)]
    private ?string $dureetraitement;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du nom')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Il faut inserer au moins {{ limit }} characteres',
        maxMessage: 'Il faut inserer au maximum {{ limit }} characteres',
    )]
    private ?string $description;

    #[ORM\ManyToOne(inversedBy: 'traitements')]
    #[ORM\JoinColumn(name: 'idvet', referencedColumnName: 'idvet')]
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

    public function getEtatdesante(): ?string
    {
        return $this->etatdesante;
    }

    public function setEtatdesante(string $etatdesante): static
    {
        $this->etatdesante = $etatdesante;

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

    public function getVeterinaire(): ?string
    {
        return $this->veterinaire;
    }

    public function setVeterinaire(string $veterinaire): static
    {
        $this->veterinaire = $veterinaire;

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


}
