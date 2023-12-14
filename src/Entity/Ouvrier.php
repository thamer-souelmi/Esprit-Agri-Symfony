<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OuvrierRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OuvrierRepository::class)]
#[ORM\Table(name: "ouvrier")]
class Ouvrier
{
    
    #[ORM\Id]

    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idOuvrier")]
    private ?int $idouvrier = null;

   
        #[ORM\Column(name: "cinOuvrier")]
        #[Assert\NotBlank(message: 'Le CIN ne doit pas être vide.')]
    #[Assert\Type(type: 'numeric', message: 'Le CIN doit être un nombre.')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'CIN ne peuvent pas être négatifs.')]
        public ?int $cinouvrier = null;

   

    #[Assert\NotBlank(message: 'La nom ne peut pas être vide.')]
    #[ORM\Column(length: 200)]
    private ?string $nomouvrier = null;

    

    #[Assert\NotBlank(message: 'La prenom ne peut pas être vide.')]
    #[ORM\Column(length: 200)]
    private ?string $prenomouvrier = null;





    #[Assert\Type(type: '\DateTimeInterface', message: 'La date de naissance doit être une date valide.')]
#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
private ?\DateTimeInterface $datenaissance;


   

    #[Assert\NotBlank(message: 'La genre ne peut pas être vide.')]
    #[ORM\Column(length: 0)]
    private ?string $genreouv = null;


    #[Assert\NotBlank(message: 'La date d\'embauche ne peut pas être vide.')]
#[Assert\GreaterThan(propertyPath: "datenaissance", message: 'La date d\'embauche doit être supérieure à la date de naissance.')]
#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
private ?\DateTimeInterface $dateembauche = null;

 
    



    
    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'L\'email ne doit pas être vide.')]
    #[Assert\Email(message: 'Format d\'email invalide.')]
    private ?string $email = null;



    #[Assert\NotBlank(message: 'L\'adresse ne peut pas être vide.')]
    #[ORM\Column(length: 200)]
    private ?string $adresse = null;




    #[Assert\NotBlank(message: 'Le numéro de téléphone ne peut pas être vide.')]
    #[Assert\Length(
        min: 8,
    max: 8,
    exactMessage: 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
    
    )]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le numéro ne peuvent pas être négatifs.')]    #[ORM\Column()]
    private ?int $phone;

  

    #[Assert\NotBlank(message: 'L\'adresse ne peut pas être vide.')]
    #[ORM\Column(length: 0)]
    private ?string $poste = null;


    
    #[Assert\NotBlank(message: 'Le numero de telephone ne peut pas être vide.')]
    #[ORM\Column()]
    private ?float $salaire;

    #[ORM\Column( length:200)]

    private ?String $photo  = null;




    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: 'ouvriers')]
    #[ORM\JoinColumn(name: "equipe_id", referencedColumnName: "idEquipe")]
    private ?Equipe $equipe = null;

    public function __construct()
    {
        
    }
    public function getphoto(): ?string
    {
        return $this->photo;
    }

    public function setphoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getNomEquipe(): ?string
    {
        // Check if equipe is set and has a NomEquipe property
        return $this->equipe ? $this->equipe->getNomEquipe() : null;
    }
    
    public function getIdouvrier(): ?int
    {
        return $this->idouvrier;
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
    
    public function getCinouvrier(): ?int
    {
        return $this->cinouvrier;
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

        public function setDatenaissance(?\DateTimeInterface $datenaissance): static
        {
            $this->datenaissance = $datenaissance;
        
            return $this;
        }

        public function getGenreouv(): ?string
    {
        return $this->genreouv;
    }

    public function setGenreouv(string $genreouv): static
    {
        $this->genreouv = $genreouv;

        return $this;
    }
    public function getDateembauche(): ?\DateTimeInterface
    {
        return $this->dateembauche;
    }

    public function setDateembauche(?\DateTimeInterface $dateembauche): static
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
    
    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
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

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;
 

        return $this;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

}
