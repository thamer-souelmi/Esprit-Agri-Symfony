<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EntretienRepository;


/**
 * Entretien
 *
 * @ORM\Table(name="entretien")
 * @ORM\Entity
 */
/**
 * @ORM\Entity(repositoryClass=EntretienRepository::class)
 */
class Entretien
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
     * @var int
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="libelleTerrain", type="integer", nullable=false)
     */
    private $libelleterrain;

    /**
     * @var string
     *
     * @ORM\Column(name="typeEntretien", type="string", length=50, nullable=false)
     */
    private $typeentretien;

    /**
     * @var string
     *
     * @ORM\Column(name="dateEntretien", type="string", length=50, nullable=false)
     */
    private $dateentretien;

    /**
     * @var string
     *
     * @ORM\Column(name="statusEntretien", type="string", length=0, nullable=false)
     */
    private $statusentretien;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEntretient", type="string", length=200, nullable=false)
     */
    private $descriptionentretient;

    /**
     * @var float
     *
     * @ORM\Column(name="chargeEntretient", type="float", precision=10, scale=0, nullable=false)
     */
    private $chargeentretient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): static
    {
        $this->userid = $userid;

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

    public function getTypeentretien(): ?string
    {
        return $this->typeentretien;
    }

    public function setTypeentretien(string $typeentretien): static
    {
        $this->typeentretien = $typeentretien;

        return $this;
    }

    public function getDateentretien(): ?string
    {
        return $this->dateentretien;
    }

    public function setDateentretien(string $dateentretien): static
    {
        $this->dateentretien = $dateentretien;

        return $this;
    }

    public function getStatusentretien(): ?string
    {
        return $this->statusentretien;
    }

    public function setStatusentretien(string $statusentretien): static
    {
        $this->statusentretien = $statusentretien;

        return $this;
    }

    public function getDescriptionentretient(): ?string
    {
        return $this->descriptionentretient;
    }

    public function setDescriptionentretient(string $descriptionentretient): static
    {
        $this->descriptionentretient = $descriptionentretient;

        return $this;
    }

    public function getChargeentretient(): ?float
    {
        return $this->chargeentretient;
    }

    public function setChargeentretient(float $chargeentretient): static
    {
        $this->chargeentretient = $chargeentretient;

        return $this;
    }


}
