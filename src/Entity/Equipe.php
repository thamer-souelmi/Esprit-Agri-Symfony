<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity
 */
class Equipe
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEquipe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="tacheAttribut", type="string", length=200, nullable=false)
     */
    private $tacheattribut;

    /**
     * @var int
     *
     * @ORM\Column(name="libelleTerrain", type="integer", nullable=false)
     */
    private $libelleterrain;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=200, nullable=false)
     */
    private $duree;

    /**
     * @var int|null
     *
     * @ORM\Column(name="userId", type="integer", nullable=true)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="NomEquipee", type="string", length=2000, nullable=false)
     */
    private $nomequipee;

    public function getIdequipe(): ?int
    {
        return $this->idequipe;
    }

    public function getTacheattribut(): ?string
    {
        return $this->tacheattribut;
    }

    public function setTacheattribut(string $tacheattribut): static
    {
        $this->tacheattribut = $tacheattribut;

        return $this;
    }

    public function getLibelleterrain(): ?int
    {
        return $this->libelleterrain;
    }

    public function setLibelleterrain(int $libelleterrain): static
    {
        $this->libelleterrain = $libelleterrain;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): static
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(?int $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getNomequipee(): ?string
    {
        return $this->nomequipee;
    }

    public function setNomequipee(string $nomequipee): static
    {
        $this->nomequipee = $nomequipee;

        return $this;
    }


}
