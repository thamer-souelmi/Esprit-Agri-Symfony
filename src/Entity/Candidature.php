<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CandidatureRepository;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature")
 * @ORM\Entity
 */
/*
@ORM\Entity(repositoryClass=CandidatureRepository::class)
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
* @Assert\NotBlank(message="vueillez ajouter votre experience professionnelle")
*/
    private $experienceprofessionnelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Formation", type="string", length=5000, nullable=true)
* @Assert\NotBlank(message="vueillez ajouter vos formation")
*/
    private $formation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CompetencesTechniques", type="string", length=5000, nullable=true)
* @Assert\NotBlank(message="vueillez ajouter vos compétence techniques  ")
*/
    private $competencestechniques;

    /**
     * @var string
     *
     * @ORM\Column(name="CertifForma", type="string", length=200, nullable=true)
     */
    private $certifforma;

    /**
     * @var string
     *
     * @ORM\Column(name="messageMotivation", type="string", length=255, nullable=false)
* @Assert\NotBlank(message="vueillez ajouter votre message de motivation")
*/
    private $messagemotivation;

  /**
 * @var bool|null
 *
 * @ORM\Column(name="statusCandidature", type="boolean", nullable=true)
 */
     private $statusCandidature;


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

    public function setCertifforma(string $certifforma): static
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

    public function getStatusCandidature(): ?bool
    {
        return $this->statusCandidature;
    }
    
    public function setStatusCandidature(?bool $statusCandidature): self
    {
        $this->statusCandidature = $statusCandidature;
    
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
