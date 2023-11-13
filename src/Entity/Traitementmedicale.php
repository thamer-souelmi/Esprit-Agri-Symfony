<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Traitementmedicale
 *
 * @ORM\Table(name="traitementmedicale")
 * @ORM\Entity
 */
class Traitementmedicale
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
     * @ORM\Column(name="numero", type="string", length=11, nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="etatDeSante", type="string", length=0, nullable=false)
     */
    private $etatdesante;

    /**
     * @var string
     *
     * @ORM\Column(name="typeIntervMed", type="string", length=0, nullable=false)
     */
    private $typeintervmed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateIntervMed", type="date", nullable=false)
     */
    private $dateintervmed;

    /**
     * @var string
     *
     * @ORM\Column(name="veterinaire", type="string", length=200, nullable=false)
     */
    private $veterinaire;

    /**
     * @var float
     *
     * @ORM\Column(name="coutInterv", type="float", precision=10, scale=0, nullable=false)
     */
    private $coutinterv;

    /**
     * @var string
     *
     * @ORM\Column(name="medicament", type="string", length=200, nullable=false)
     */
    private $medicament;

    /**
     * @var string
     *
     * @ORM\Column(name="dureeTraitement", type="string", length=200, nullable=false)
     */
    private $dureetraitement;

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
