<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature", indexes={@ORM\Index(name="fk_candidature_annonce", columns={"idRecurt"})})
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
     * @var string
     *
     * @ORM\Column(name="messageMotivation", type="string", length=255, nullable=false)
     */
    private $messagemotivation;

    /**
     * @var string
     *
     * @ORM\Column(name="statusCandidature", type="string", length=0, nullable=false)
     */
    private $statuscandidature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCandidature", type="date", nullable=false)
     */
    private $datecandidature;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idRecurt", type="integer", nullable=true)
     */
    private $idrecurt;

    public function getIdcandidature(): ?int
    {
        return $this->idcandidature;
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

    public function setStatuscandidature(string $statuscandidature): static
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

    public function getIdrecurt(): ?int
    {
        return $this->idrecurt;
    }

    public function setIdrecurt(?int $idrecurt): static
    {
        $this->idrecurt = $idrecurt;

        return $this;
    }


}
