<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatureRepository;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[ORM\Table(name: "candidature")]


class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idCandidature")]

    private ?int $idcandidature = null;

    #[ORM\Column( length: 5000)]

    private ?String $experienceprofessionnelle = null;


    #[ORM\Column( length:5000)]

    private ?String $formation  = null;

    #[ORM\Column( length:5000)]

    private ?String $competencestechniques = null;

    
    #[ORM\Column( length:200)]

    private ?String $certifforma  = null;

   
    #[ORM\Column( length:255,)]

    private String $messagemotivation;


    #[ORM\Column(type: Types::DATE_MUTABLE)]

    private ?\DateTimeInterface $datecandidature = null;

  
    #[ORM\Column]

    private ?bool $statuscandidature;

   
    // #[ORM\ManyToOne(targetEntity: "App\Entity\Annoncerecrutement", inversedBy: "candidatures")]
    // #[ORM\JoinColumn(nullable: true)]
    // private ?Annoncerecrutement $idannrecru;
    
    
    

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

    // public function getIdannrecru(): ?Annoncerecrutement
    // {
    //     return $this->idannrecru;
    // }

    // public function setIdannrecru(?Annoncerecrutement $idannrecru): static
    // {
    //     $this->idannrecru = $idannrecru;

    //     return $this;
    // }




}
