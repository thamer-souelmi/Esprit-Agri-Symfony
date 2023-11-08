<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceinvestissementRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Annonceinvestissement
 *
 * @ORM\Table(name="annonceinvestissement")
 * @ORM\Entity
 */
/**
 * @ORM\Entity(repositoryClass=AnnonceinvestissementRepository::class)
 */
class Annonceinvestissement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAnnonce", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idannonce;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=200, nullable=false)
     * @Assert\NotBlank(message="Titre is required")
     */
    private $titre;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Montant is required")
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePublication", type="date", nullable=false)
     * @Assert\NotBlank(message="Date de publication is required")
     */
    private $datepublication;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Localisation is required")
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
     * @Assert\NotBlank(message="Description is required")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=500, nullable=false)
     */
    private $photo;

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     */
    private $iduser;

    public function getIdannonce(): ?int
    {
        return $this->idannonce;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDatepublication(): ?\DateTimeInterface
    {
        return $this->datepublication;
    }

    public function setDatepublication(\DateTimeInterface $datepublication): static
    {
        $this->datepublication = $datepublication;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }


}
