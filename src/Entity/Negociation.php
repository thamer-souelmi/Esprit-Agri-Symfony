<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\NegociationRepository;
use App\Entity\Annonceinvestissement;

#[ORM\Entity(repositoryClass: NegociationRepository::class)]
class Negociation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: "montantPropose", type: "float", precision: 10, scale: 0, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter le montant proposé !")]
    private $montantpropose;

    #[ORM\Column(name: "message", type: "string", length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter un message pour l'agriculteur !")]
    private $message;

    #[ORM\Column(name: "etatNego", type: "boolean", length: 0, nullable: true)]
    private $etatnego;

    #[ORM\Column(name: "dateNegociation", type: "date", nullable: false)]
    #[Assert\NotBlank(message: "Veuillez ajouter la date de négociation !")]
    private $datenegociation;

    
    #[ORM\ManyToOne(inversedBy: 'negociations')]
    #[ORM\JoinColumn(name:'idAnnonce',referencedColumnName:'idAnnonce')]
     private ?Annonceinvestissement $idannonce = null;

    #[ORM\Column]
    private ?bool $isArchived = null;

    #[ORM\ManyToOne(inversedBy: 'negociations')]
    private ?User $users = null;
 
    
    


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

    public function isIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }
}