<?php

namespace App\Entity;

use App\Entity\Category;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CultrueRepository::class)]

class Culture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    //
    #[Assert\NotBlank(message: 'veuillez remplir ce champ')]
    #[Assert\Length(min: 3, minMessage: 'Le libelle doit comporter au moins {{ limit }} caractères')]
    #[ORM\Column(length: 200)]
    private ?string $libelle = null;
    //


    #[Assert\NotBlank(message: 'veuillez remplir tous les champs obligatoires')]
    #[Assert\LessThan(propertyPath: "daterecolte", message: "La date de plantation doit être inférieure à la date de recolte.")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateplantation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $daterecolte = null;
    //
    #[ORM\Column(length: 150)]
    private ?string $categorytype = null;


    #[Assert\NotBlank(message: 'Les revenus des cultures ne peuvent pas être vides.')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Les revenus des cultures ne peuvent pas être négatifs.')]
    #[ORM\Column]
    private ?float $revenuescultures = null;



    #[Assert\NotBlank(message: 'Les couts des cultures ne peuvent pas être vides.')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Les couts des cultures ne peuvent pas être négatifs.')]
    #[ORM\Column]
    private ?float $coutsplantations = null;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Category", inversedBy: "cultures")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $categorys = null;

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getDateplantation(): ?\DateTimeInterface
    {
        return $this->dateplantation;
    }

    public function setDateplantation(\DateTimeInterface $dateplantation): static
    {
        $this->dateplantation = $dateplantation;
        return $this;
    }

    public function getDaterecolte(): ?\DateTimeInterface
    {
        return $this->daterecolte;
    }

    public function setDaterecolte(\DateTimeInterface $daterecolte): static
    {
        $this->daterecolte = $daterecolte;
        return $this;
    }

    public function getCategorytype(): ?string
    {
        return $this->categorytype;
    }

    public function setCategorytype(string $categorytype): static
    {
        $this->categorytype = $categorytype;
        return $this;
    }

    public function getRevenuescultures(): ?float
    {
        return $this->revenuescultures;
    }

    public function setRevenuescultures(float $revenuescultures): static
    {
        $this->revenuescultures = $revenuescultures;
        return $this;
    }

    public function getCoutsplantations(): ?float
    {
        return $this->coutsplantations;
    }

    public function setCoutsplantations(float $coutsplantations): static
    {
        $this->coutsplantations = $coutsplantations;
        return $this;
    }

    public function getCategorys(): ?Category
    {
        return $this->categorys;
    }

    public function setCategorys(?Category $categorys): static
    {
        $this->categorys = $categorys;

        return $this;
    }

    

    
}
