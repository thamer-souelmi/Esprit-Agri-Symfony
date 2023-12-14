<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipeRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
#[ORM\Table(name: "equipe")]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idEquipe")]
    private ?int $idEquipe = null;

    #[Assert\NotBlank(message: 'tache ne peut pas être vide.')]
    #[ORM\Column(length: 200)]
    private ?string $tacheAttribut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebut;

    #[Assert\NotBlank(message: 'La duree ne peut pas être vide.')]
    #[ORM\Column(length: 200)]
    private string $duree;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'nom ne peut pas être vide.')]
    private ?string $NomEquipe = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Ouvrier::class)]
    private Collection $ouvriers;

    public function __construct()
    {
        $this->ouvriers = new ArrayCollection();
    }

    public function getidEquipe(): ?int
    {
        return $this->idEquipe;
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

    public function gettacheAttribut(): ?string
    {
        return $this->tacheAttribut;
    }

    public function settacheAttribut(?string $tacheAttribut): static
    {
        $this->tacheAttribut = $tacheAttribut;

        return $this;
    }

    public function getdateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setdateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getduree(): ?string
    {
        return $this->duree;
    }

    public function setduree(string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNomEquipe(): ?string
    {
        return $this->NomEquipe;
    }

    public function setNomEquipe(string $NomEquipe): static
    {
        $this->NomEquipe = $NomEquipe;

        return $this;
    }

    /**
     * @return Collection<int, Ouvrier>
     */
    public function getOuvriers(): Collection
    {
        return $this->ouvriers;
    }

    public function addOuvrier(Ouvrier $ouvrier): static
    {
        if (!$this->ouvriers->contains($ouvrier)) {
            $this->ouvriers->add($ouvrier);
            $ouvrier->setEquipe($this);
        }

        return $this;
    }

    public function removeOuvrier(Ouvrier $ouvrier): static
    {
        if ($this->ouvriers->removeElement($ouvrier)) {
            // set the owning side to null (unless already changed)
            if ($ouvrier->getEquipe() === $this) {
                $ouvrier->setEquipe(null);
            }
        }

        return $this;
    }
}
