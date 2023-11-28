<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use App\Repository\AnnoncerecrutementRepository;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\DBAL\Types\Types;
    use Symfony\Component\Validator\Constraints as Assert;

    #[ORM\Entity(repositoryClass: AnnoncerecrutementRepository::class)]
    #[ORM\Table(name: "annoncerecrutement")]
    class Annoncerecrutement
    {
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: "IDENTITY")]
        #[ORM\Column(name: "idRecrut")]
        private ?int $idRecrut = null;

       #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
        #[ORM\Column(length: 255)]
        private ?string $posteDemande = null;

        #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
         #[ORM\Column(precision: 10, scale: 0)]
         private ?float $salairePropose = null;

        #[Assert\NotBlank(message: 'Ce champ ne peut pas être vide.')]
         #[ORM\Column(length: 0)]
         private ?string $typeContrat = null;

        #[ORM\Column(type: Types::DATE_MUTABLE)]
        private ?\DateTimeInterface $datePub = null;

       #[Assert\NotBlank(message: 'La localisation ne peut pas être vide.')]
        #[ORM\Column(length: 25)]
        private ?string $localisation = null;

        #[Assert\NotBlank(message: 'La date d\'embauche ne peut pas être vide.')]
        #[Assert\GreaterThan(propertyPath: "datePub", message: 'La date d\'embauche doit être supérieure à la date de publication.')]
        #[ORM\Column(type: Types::DATE_MUTABLE)]
        private ?\DateTimeInterface $dateEmbauche;

        #[Assert\NotBlank(message: 'Le nombre de postes recherchés ne peut pas être vide.')]
        #[ORM\Column()]
        private ?int $nbPosteRecherche;

        #[ORM\Column(name: "filter1", length: 255)]
private ?string $filter1 ;
#[ORM\Column(name: "archivedA")]
private ?bool $archivedA ;

        #[ORM\OneToMany(mappedBy: "idannrecru", targetEntity: Candidature::class)]
        private Collection $candidatures;

        #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user;


    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
    }

        public function getIdRecrut(): ?int
        {
            return $this->idRecrut;
        }

        public function getPosteDemande(): ?string
        {
            return $this->posteDemande;
        }
    
        public function setPosteDemande(string $posteDemande): self
        {
            $this->posteDemande = $posteDemande;
    
            return $this;
        }



        public function getfilter1(): ?float
        {
            return $this->filter1;
        }

        public function setfilter1e(string $filter1): self
        {
            $this->filter1 = $filter1;

            return $this;
        }
        public function getSalairePropose(): ?float
        {
            return $this->salairePropose;
        }

        public function setSalairePropose(float $salairePropose): static
        {
            $this->salairePropose = $salairePropose;

            return $this;
        }

        public function getTypeContrat(): ?string
        {
            return $this->typeContrat;
        }

        public function setTypeContrat(string $typeContrat): static
        {
            $this->typeContrat = $typeContrat;

            return $this;
        }

        public function getDatePub(): ?\DateTimeInterface
        {
            return $this->datePub;
        }

        public function setDatePub(\DateTimeInterface $datePub): static
        {
            $this->datePub = $datePub;

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

        public function getDateEmbauche(): ?\DateTimeInterface
        {
            return $this->dateEmbauche;
        }

        public function setDateEmbauche(\DateTimeInterface $dateEmbauche): static
        {
            $this->dateEmbauche = $dateEmbauche;

            return $this;
        }

        public function getNbPosteRecherche(): ?int
        {
            return $this->nbPosteRecherche;
        }

        public function setNbPosteRecherche(int $nbPosteRecherche): static
        {
            $this->nbPosteRecherche = $nbPosteRecherche;

            return $this;
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

        public function isArchivedA(): bool
        {
            return $this->archivedA;
        }
    
        public function setArchivedA(bool $archived): self
        {
            $this->archivedA = $archived;
            return $this;
        }

        /**
         * @return Collection|Candidature[]
         */
        public function getCandidatures(): Collection
        {
            return $this->candidatures;
        }

        public function getCandidaturesCount(): int
    {
        return $this->candidatures->count();
    }
        public function addCandidature(Candidature $candidature): self
        {
            if (!$this->candidatures->contains($candidature)) {
                $this->candidatures[] = $candidature;
                $candidature->setIdannrecru($this);
            }

            return $this;
        }

        public function removeCandidature(Candidature $candidature): self
        {
            if ($this->candidatures->removeElement($candidature)) {
                // set the owning side to null (unless already changed)
                if ($candidature->getIdannrecru() === $this) {
                    $candidature->setIdannrecru(null);
                }
            }

            return $this;
        }
    }
