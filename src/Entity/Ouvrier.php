<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OuvrierRepository;

/**
 * Ouvrier
 *
 * @ORM\Table(name="ouvrier")
 * @ORM\Entity
 */
/**
 * @ORM\Entity(repositoryClass=OuvrierRepository::class)
 */
class Ouvrier
{
    /**
     * @var int
     *
     * @ORM\Column(name="idOuvrier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idouvrier;

    /**
     * @var string
     *
     * @ORM\Column(name="cinOuvrier", type="string", length=200, nullable=false)
     */
    private $cinouvrier;

    /**
     * @var string
     *
     * @ORM\Column(name="nomOuvrier", type="string", length=200, nullable=false)
     */
    private $nomouvrier;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomOuvrier", type="string", length=200, nullable=false)
     */
    private $prenomouvrier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=false)
     */
    private $datenaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=0, nullable=false)
     */
    private $genre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEmbauche", type="date", nullable=false)
     */
    private $dateembauche;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=200, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=200, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="poste", type="string", length=0, nullable=false)
     */
    private $poste;

    /**
     * @var int|null
     *
     * @ORM\Column(name="userId", type="integer", nullable=true)
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="NomEquipe", type="string", length=200, nullable=false)
     */
    private $nomequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=200, nullable=false)
     */
    private $photo;

    public function getIdouvrier(): ?int
    {
        return $this->idouvrier;
    }

    public function getCinouvrier(): ?string
    {
        return $this->cinouvrier;
    }

    public function setCinouvrier(string $cinouvrier): static
    {
        $this->cinouvrier = $cinouvrier;

        return $this;
    }

    public function getNomouvrier(): ?string
    {
        return $this->nomouvrier;
    }

    public function setNomouvrier(string $nomouvrier): static
    {
        $this->nomouvrier = $nomouvrier;

        return $this;
    }

    public function getPrenomouvrier(): ?string
    {
        return $this->prenomouvrier;
    }

    public function setPrenomouvrier(string $prenomouvrier): static
    {
        $this->prenomouvrier = $prenomouvrier;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(\DateTimeInterface $datenaissance): static
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): static
    {
        $this->poste = $poste;

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

    public function getNomequipe(): ?string
    {
        return $this->nomequipe;
    }

    public function setNomequipe(string $nomequipe): static
    {
        $this->nomequipe = $nomequipe;

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


}
