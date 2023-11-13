<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Culture
 *
 * @ORM\Table(name="culture")
 * @ORM\Entity
 */
class Culture
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=200, nullable=false)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePlantation", type="date", nullable=false)
     */
    private $dateplantation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateRecolte", type="date", nullable=false)
     */
    private $daterecolte;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryType", type="string", length=40, nullable=false)
     */
    private $categorytype;

    /**
     * @var float
     *
     * @ORM\Column(name="revenuesCultures", type="float", precision=10, scale=0, nullable=false)
     */
    private $revenuescultures;

    /**
     * @var float
     *
     * @ORM\Column(name="coutsPlantations", type="float", precision=10, scale=0, nullable=false)
     */
    private $coutsplantations;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

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

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }


}
