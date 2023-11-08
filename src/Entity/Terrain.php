<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Terrain
 *
 * @ORM\Table(name="terrain")
 * @ORM\Entity
 */
class Terrain
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
     * @var int
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="libelleTerrain", type="integer", nullable=false)
     */
    private $libelleterrain;

    /**
     * @var float
     *
     * @ORM\Column(name="superficie", type="float", precision=10, scale=0, nullable=false)
     */
    private $superficie;

    /**
     * @var string
     *
     * @ORM\Column(name="etatSol", type="string", length=0, nullable=false)
     */
    private $etatsol;

    /**
     * @var int
     *
     * @ORM\Column(name="idCategory", type="integer", nullable=false)
     */
    private $idcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=200, nullable=false)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=500, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionTerrain", type="string", length=200, nullable=false)
     */
    private $descriptionterrain;

    /**
     * @var float
     *
     * @ORM\Column(name="valeurTerrain", type="float", precision=10, scale=0, nullable=false)
     */
    private $valeurterrain;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getLibelleterrain(): ?int
    {
        return $this->libelleterrain;
    }

    public function setLibelleterrain(int $libelleterrain): static
    {
        $this->libelleterrain = $libelleterrain;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): static
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getEtatsol(): ?string
    {
        return $this->etatsol;
    }

    public function setEtatsol(string $etatsol): static
    {
        $this->etatsol = $etatsol;

        return $this;
    }

    public function getIdcategory(): ?int
    {
        return $this->idcategory;
    }

    public function setIdcategory(int $idcategory): static
    {
        $this->idcategory = $idcategory;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescriptionterrain(): ?string
    {
        return $this->descriptionterrain;
    }

    public function setDescriptionterrain(string $descriptionterrain): static
    {
        $this->descriptionterrain = $descriptionterrain;

        return $this;
    }

    public function getValeurterrain(): ?float
    {
        return $this->valeurterrain;
    }

    public function setValeurterrain(float $valeurterrain): static
    {
        $this->valeurterrain = $valeurterrain;

        return $this;
    }


}
