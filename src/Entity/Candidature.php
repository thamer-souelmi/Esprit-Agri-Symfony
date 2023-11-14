<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature")
 * @ORM\Entity
 */
class Candidature
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCandidature", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcandidature;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ExperienceProfessionnelle", type="string", length=5000, nullable=true)
     */
    private $experienceprofessionnelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Formation", type="string", length=5000, nullable=true)
     */
    private $formation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CompetencesTechniques", type="string", length=5000, nullable=true)
     */
    private $competencestechniques;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CertifForma", type="string", length=200, nullable=true)
     */
    private $certifforma;

    /**
     * @var string
     *
     * @ORM\Column(name="messageMotivation", type="string", length=255, nullable=false)
     */
    private $messagemotivation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="statusCandidature", type="string", length=0, nullable=true)
     */
    private $statuscandidature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCandidature", type="date", nullable=false)
     */

     
    private $datecandidature;

    public function getIdcandidature(): ?int
    {
        return $this->idcandidature;
    }

    public function getExperienceprofessionnelle(): ?string
    {
        return $this->experienceprofessionnelle;
    }

    public function setExperienceprofessionnelle(?string $experienceprofessionnelle): static
    {
        $this->experienceprofessionnelle = $experienceprofessionnelle;

        return $this;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function setFormation(?string $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getCompetencestechniques(): ?string
    {
        return $this->competencestechniques;
    }

    public function setCompetencestechniques(?string $competencestechniques): static
    {
        $this->competencestechniques = $competencestechniques;

        return $this;
    }

    public function getCertifforma(): ?string
    {
        return $this->certifforma;
    }

    public function setCertifforma(?string $certifforma): static
    {
        $this->certifforma = $certifforma;

        return $this;
    }

    public function getMessagemotivation(): ?string
    {
        return $this->messagemotivation;
    }

    public function setMessagemotivation(string $messagemotivation): static
    {
        $this->messagemotivation = $messagemotivation;

        return $this;
    }

    public function getStatuscandidature(): ?string
    {
        return $this->statuscandidature;
    }

    public function setStatuscandidature(?string $statuscandidature): static
    {
        $this->statuscandidature = $statuscandidature;

        return $this;
    }

    public function getDatecandidature(): ?\DateTimeInterface
    {
        return $this->datecandidature;
    }

    public function setDatecandidature(\DateTimeInterface $datecandidature): static
    {
        $this->datecandidature = $datecandidature;

        return $this;
    }


}
