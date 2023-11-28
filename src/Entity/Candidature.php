<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[ORM\Table(name: "candidature")]
class Candidature
{
    private $confirmed; // Declare the property

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idCandidature")]
    private ?int $idcandidature = null;

    #[Assert\NotBlank(message: 'Le nombre de postes recherchés ne peut pas être vide.')]

    #[ORM\Column( length: 5000)]

    private ?String $experienceprofessionnelle = null;

    #[Assert\NotBlank(message: 'Le nombre de postes recherchés ne peut pas être vide.')]

    #[ORM\Column( length:5000)]

    private ?String $formation  = null;
    #[Assert\NotBlank(message: 'Le nombre de postes recherchés ne peut pas être vide.')]

    #[ORM\Column( length:5000)]

    private ?String $competencestechniques = null;


    #[ORM\Column( length:200)]

    private ?String $certifforma  = null;

    #[Assert\NotBlank(message: 'Le nombre de postes recherchés ne peut pas être vide.')]

    #[ORM\Column( length:255,)]

    private String $messagemotivation;


    #[ORM\Column(type: Types::DATE_MUTABLE)]

    private ?\DateTimeInterface $datecandidature = null;

  
    #[ORM\Column]

    private ?bool $statuscandidature = false;

    #[ORM\Column]

    private ?bool $archived = false;

   
    #[ORM\ManyToOne(targetEntity: "App\Entity\Annoncerecrutement", inversedBy: "candidatures")]
    #[ORM\JoinColumn(name: "idannrecru_id", referencedColumnName: "idRecrut")]
    private ?Annoncerecrutement $idannrecru;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user;
    
    
    public function __construct()
{
    $this->statuscandidature = false;
    // Add any other default values here if needed
}

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

    public function getDatecandidature(): ?\DateTimeInterface
    {
        return $this->datecandidature;
    }

    public function setDatecandidature(\DateTimeInterface $datecandidature): static
    {
        $this->datecandidature = $datecandidature;

        return $this;
    }

    public function isStatuscandidature(): ?bool
    {
        return $this->statuscandidature;
    }

    public function setStatuscandidature(?bool $statuscandidature): static
    {
        $this->statuscandidature = $statuscandidature;

        return $this;
    }

    public function getIdannrecru(): ?Annoncerecrutement
    {
        return $this->idannrecru;
    }

    public function setIdannrecru(?Annoncerecrutement $idannrecru): static
    {
        $this->idannrecru = $idannrecru;

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

    public function isConfirmed()
    {
        // Logic to determine if the candidature is confirmed
        // For example, you might have a 'confirmed' property on the entity
        return $this->confirmed === true;
    }



}
