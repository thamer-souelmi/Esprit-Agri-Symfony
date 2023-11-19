<?php
namespace App\Entity;

//namespace App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]

class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le CIN ne doit pas être vide.')]
    #[Assert\Type(type: 'numeric', message: 'Le CIN doit être un nombre.')]
    private ?string $cin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'Le nom ne doit pas être vide.')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Il faut inserer au moins {{ limit }} characteres',
        maxMessage: 'Il faut inserer au maximum {{ limit }} characteres',
    )]
    #[Assert\Type(
        type:"string",
        message:"veuillez inserer un nom correct "
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'Le pronom ne doit pas être vide.')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le mot de passe ne doit pas être vide.')]
    #[Assert\Length(
        min: 8,
        minMessage: 'Le mot de passe doit contenir au moins 8 caractères.'
    )]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'email ne doit pas être vide.')]
    #[Assert\Email(message: 'Format d\'email invalide.')]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'adresse ne peut pas être vide.')]
    #[Assert\Length(max: 50, maxMessage: 'L\'adresse ne peut pas dépasser {{ limit }} caractères.')]
    private ?int $adresse = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le numéro de téléphone ne peut pas être vide.')]
    #[Assert\Length(
        min: 8,
    max: 8,
    exactMessage: 'Le numéro de téléphone doit comporter exactement {{ limit }} chiffres.',
    
    )]
    private ?int $numtel = null;

    #[ORM\Column(length: 255)]
    private $role;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

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

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): static
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
    public function getRoles()
    {
        return [$this->role]; // You might need to adjust this depending on your use case
    }

    public function getPassword()
    {
        return $this->mdp;
    }

    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function getUsername()
    {
        return $this->mail;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    
    


}