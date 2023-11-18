<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\NegociationRepository;

/**
 * Negociation
 *
 * @ORM\Table(name="negociation", indexes={@ORM\Index(name="fk_annonceinvestissement", columns={"idAnnonce"})})
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
     * @Assert\NotBlank(message="Veuillez ajouter le montant proposé !")
     */
    private $montantpropose;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter un message pour l'agriculteur !")
     */
    private $message;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etatNego", type="boolean", length=0, nullable=true)
     */
    private $etatnego;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNegociation", type="date", nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter la date de négociation !")
     */
    private $datenegociation;

    /**
     * @var \Annonceinvestissement
     *
     * @ORM\ManyToOne(targetEntity="Annonceinvestissement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idAnnonce", referencedColumnName="idAnnonce")
     * })
     */
    private $idannonce;

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

    public function setEtatnego(?string $etatnego): static
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

    public function getIdannonce(): ?Annonceinvestissement
    {
        return $this->idannonce;
    }

    public function setIdannonce(?Annonceinvestissement $idannonce): static
    {
        $this->idannonce = $idannonce;

        return $this;
    }


}
