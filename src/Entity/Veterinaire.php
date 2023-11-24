<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\VeterinaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VeterinaireRepository::class)]
class Veterinaire
{   #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idvet;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du nom')]
    private ?string $nomvet;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du prenom')]
    private ?string $prenomvet;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'veuillez remplir ce champ')]
    #[Assert\Regex(
        pattern: '/^[^:]+: .+$/',
        message: 'Le format doit être "ville : adresse".'
    )]
    private ?string $adresscabinet;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du numero')]
    #[Assert\Length(
        min: 8,
    max: 8,
    exactMessage: 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
    
    )]
    private ?int $numtel;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'veuillez remplir le champ du mail')]
    #[Assert\Email(message: 'Format d\'email invalide.')]
    private ?string $adressmail;

    #[ORM\Column(length: 200)]
    private ?string $specialite;
    // #[ORM\OneToMany(mappedBy: 'idvet', targetEntity: Traitementmedicale::class, cascade: ['remove'])]
    #[ORM\OneToMany(mappedBy: 'idvet', targetEntity: Traitementmedicale::class)]
    private Collection $traitements;

    #[ORM\OneToMany(mappedBy: 'veterinaire', targetEntity: Note::class)]
    private Collection $notes;

    public function __construct()
    {
        $this->traitements = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getIdvet(): ?int
    {
        return $this->idvet;
    }

    public function getNomvet(): ?string
    {
        return $this->nomvet;
    }

    public function setNomvet(string $nomvet): static
    {
        $this->nomvet = $nomvet;

        return $this;
    }

    public function getPrenomvet(): ?string
    {
        return $this->prenomvet;
    }

    public function setPrenomvet(string $prenomvet): static
    {
        $this->prenomvet = $prenomvet;

        return $this;
    }

    public function getAdresscabinet(): ?string
    {
        return $this->adresscabinet;
    }

    public function setAdresscabinet(string $adresscabinet): static
    {
        $this->adresscabinet = $adresscabinet;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getAdressmail(): ?string
    {
        return $this->adressmail;
    }

    public function setAdressmail(string $adressmail): static
    {
        $this->adressmail = $adressmail;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }
    /**
     * @return Collection<int, Traitementmedicale>
     */
   public function getTraitements(): Collection
   {
       return $this->traitements;
   }
   public function addTraitement(Traitementmedicale $traitement): static
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements->add($traitement);
            $traitement->setIdvet($this);
        }

        return $this;
    }
    public function removeTraitement(Traitementmedicale $traitement): static
    {
        if ($this->traitements->removeElement($traitement)) {
            // Mettez à jour la relation inverse pour éviter les erreurs
            if ($traitement->getIdvet() === $this) {
                $traitement->setIdvet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setVeterinaire($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getVeterinaire() === $this) {
                $note->setVeterinaire(null);
            }
        }

        return $this;
    }


}
