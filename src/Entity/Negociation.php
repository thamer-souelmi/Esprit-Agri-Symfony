<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Negociation
 *
 * @ORM\Table(name="negociation")
 * @ORM\Entity
 */
class Negociation
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
     * @var float
     *
     * @ORM\Column(name="montantPropose", type="float", precision=10, scale=0, nullable=false)
     */
    private $montantpropose;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=false)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="etatNego", type="string", length=0, nullable=false)
     */
    private $etatnego;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNegociation", type="date", nullable=false)
     */
    private $datenegociation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantpropose(): ?float
    {
        return $this->montantpropose;
    }

    public function setMontantpropose(float $montantpropose): static
    {
        $this->montantpropose = $montantpropose;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getEtatnego(): ?string
    {
        return $this->etatnego;
    }

    public function setEtatnego(string $etatnego): static
    {
        $this->etatnego = $etatnego;

        return $this;
    }

    public function getDatenegociation(): ?\DateTimeInterface
    {
        return $this->datenegociation;
    }

    public function setDatenegociation(\DateTimeInterface $datenegociation): static
    {
        $this->datenegociation = $datenegociation;

        return $this;
    }


}
