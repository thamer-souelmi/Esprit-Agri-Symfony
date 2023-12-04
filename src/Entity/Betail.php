<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Betail
 *
 * @ORM\Table(name="betail")
 * @ORM\Entity
 */
class Betail
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
     * @ORM\Column(name="categbetail", type="string", length=0, nullable=false)
     */
    private $categbetail;

    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=0, nullable=false)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=0, nullable=false)
     */
    private $genre;

    /**
     * @var float
     *
     * @ORM\Column(name="poids", type="float", precision=10, scale=0, nullable=false)
     */
    private $poids;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeNaissance", type="date", nullable=false)
     */
    private $datedenaissance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="userId", type="integer", nullable=true)
     */
    private $userid;

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

    public function getCategbetail(): ?string
    {
        return $this->categbetail;
    }

    public function setCategbetail(string $categbetail): static
    {
        $this->categbetail = $categbetail;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): static
    {
        $this->race = $race;

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

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDatedenaissance(): ?\DateTimeInterface
    {
        return $this->datedenaissance;
    }

    public function setDatedenaissance(\DateTimeInterface $datedenaissance): static
    {
        $this->datedenaissance = $datedenaissance;

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


}
