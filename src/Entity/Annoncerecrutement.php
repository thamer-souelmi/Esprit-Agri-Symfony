<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Annoncerecrutement
 *
 * @ORM\Table(name="annoncerecrutement")
 * @ORM\Entity
 */
class Annoncerecrutement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRecurt", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrecurt;

    /**
     * @var string
     *
     * @ORM\Column(name="posteDemande", type="string", length=255, nullable=false)
     */
    private $postedemande;

    /**
     * @var float
     *
     * @ORM\Column(name="salairePropose", type="float", precision=10, scale=0, nullable=false)
     */
    private $salairepropose;

    /**
     * @var string
     *
     * @ORM\Column(name="typeContrat", type="string", length=0, nullable=false)
     */
    private $typecontrat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePub", type="date", nullable=false)
     */
    private $datepub;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
     */
    private $localisation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEmbauche", type="date", nullable=false)
     */
    private $dateembauche;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPosteRecherche", type="integer", nullable=false)
     */
    private $nbposterecherche;

    public function getIdrecurt(): ?int
    {
        return $this->idrecurt;
    }

    public function getPostedemande(): ?string
    {
        return $this->postedemande;
    }

    public function setPostedemande(string $postedemande): static
    {
        $this->postedemande = $postedemande;

        return $this;
    }

    public function getSalairepropose(): ?float
    {
        return $this->salairepropose;
    }

    public function setSalairepropose(float $salairepropose): static
    {
        $this->salairepropose = $salairepropose;

        return $this;
    }

    public function getTypecontrat(): ?string
    {
        return $this->typecontrat;
    }

    public function setTypecontrat(string $typecontrat): static
    {
        $this->typecontrat = $typecontrat;

        return $this;
    }

    public function getDatepub(): ?\DateTimeInterface
    {
        return $this->datepub;
    }

    public function setDatepub(\DateTimeInterface $datepub): static
    {
        $this->datepub = $datepub;

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

    public function getDateembauche(): ?\DateTimeInterface
    {
        return $this->dateembauche;
    }

    public function setDateembauche(\DateTimeInterface $dateembauche): static
    {
        $this->dateembauche = $dateembauche;

        return $this;
    }

    public function getNbposterecherche(): ?int
    {
        return $this->nbposterecherche;
    }

    public function setNbposterecherche(int $nbposterecherche): static
    {
        $this->nbposterecherche = $nbposterecherche;

        return $this;
    }


}
