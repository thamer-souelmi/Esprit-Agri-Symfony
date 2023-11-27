<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OuvrierRepository;

#[ORM\Entity(repositoryClass: OuvrierRepository::class)]
#[ORM\Table(name: "ouvrier")]

class Ouvrier
{
   

     #[ORM\Id]

     #[ORM\GeneratedValue]

     #[ORM\Column(name: "idOuvrier")]
    private  ?int $idouvrier= null;

 
   
    #[ORM\Column(type: Types::DATE_MUTABLE)]

    private  ?\DateTimeInterface  $dateembauche= null;

    #[ORM\Column(length:0)]

    private ?String $poste= null;

    #[ORM\Column(length:200)]

    private ?String $nomequipe = null;


    public function getIdouvrier(): ?int
    {
        return $this->idouvrier;
    }
    public function getDateembauche(): ?\DateTimeInterface
    {
        return $this->dateembauche;
    }

    public function setDateembauche(\DateTimeInterface $dateembauche): static
    {
        $this->dateembauche = $dateembauche;

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
    public function getNomequipe(): ?string
    {
        return $this->nomequipe;
    }

    public function setNomequipe(string $nomequipe): static
    {
        $this->nomequipe = $nomequipe;

        return $this;
    }


}
