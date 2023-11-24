<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "bilanresultat")]
#[ORM\Entity]
class Bilanresultat
{
    #[ORM\Column(name: "idBilanR", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $idbilanr;

    #[ORM\Column(name: "anneeR", type: "date", nullable: false)]
    private $anneer;

    #[ORM\Column(name: "idUser", type: "integer", nullable: false)]
    private $iduser;

    #[ORM\Column(name: "autreRevenus", type: "float", precision: 10, scale: 0, nullable: false)]
    private $autrerevenus;

    #[ORM\Column(name: "subvention", type: "float", precision: 10, scale: 0, nullable: false)]
    private $subvention;

    #[ORM\Column(name: "revenuesCultures", type: "float", precision: 10, scale: 0, nullable: false)]
    private $revenuescultures;

    #[ORM\Column(name: "semences", type: "float", precision: 10, scale: 0, nullable: false)]
    private $semences;

    #[ORM\Column(name: "coutMainOeuvre", type: "float", precision: 10, scale: 0, nullable: false)]
    private $coutmainoeuvre;

    #[ORM\Column(name: "coutInterventionMedicale", type: "float", precision: 10, scale: 0, nullable: false)]
    private $coutinterventionmedicale;

    #[ORM\Column(name: "coutsPlantations", type: "float", precision: 10, scale: 0, nullable: false)]
    private $coutsplantations;

    #[ORM\Column(name: "chargesElectricite", type: "float", precision: 10, scale: 0, nullable: false)]
    private $chargeselectricite;

    #[ORM\Column(name: "chargeEntretien", type: "float", precision: 10, scale: 0, nullable: false)]
    private $chargeentretien;

    #[ORM\Column(name: "chargeAdministratives", type: "float", precision: 10, scale: 0, nullable: false)]
    private $chargeadministratives;

    public function getIdbilanr(): ?int
    {
        return $this->idbilanr;
    }

    public function getAnneer(): ?\DateTimeInterface
    {
        return $this->anneer;
    }

    public function setAnneer(\DateTimeInterface $anneer): static
    {
        $this->anneer = $anneer;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getAutrerevenus(): ?float
    {
        return $this->autrerevenus;
    }

    public function setAutrerevenus(float $autrerevenus): static
    {
        $this->autrerevenus = $autrerevenus;

        return $this;
    }

    public function getSubvention(): ?float
    {
        return $this->subvention;
    }

    public function setSubvention(float $subvention): static
    {
        $this->subvention = $subvention;

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

    public function getSemences(): ?float
    {
        return $this->semences;
    }

    public function setSemences(float $semences): static
    {
        $this->semences = $semences;

        return $this;
    }

    public function getCoutmainoeuvre(): ?float
    {
        return $this->coutmainoeuvre;
    }

    public function setCoutmainoeuvre(float $coutmainoeuvre): static
    {
        $this->coutmainoeuvre = $coutmainoeuvre;

        return $this;
    }

    public function getCoutinterventionmedicale(): ?float
    {
        return $this->coutinterventionmedicale;
    }

    public function setCoutinterventionmedicale(float $coutinterventionmedicale): static
    {
        $this->coutinterventionmedicale = $coutinterventionmedicale;

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

    public function getChargeselectricite(): ?float
    {
        return $this->chargeselectricite;
    }

    public function setChargeselectricite(float $chargeselectricite): static
    {
        $this->chargeselectricite = $chargeselectricite;

        return $this;
    }

    public function getChargeentretien(): ?float
    {
        return $this->chargeentretien;
    }

    public function setChargeentretien(float $chargeentretien): static
    {
        $this->chargeentretien = $chargeentretien;

        return $this;
    }

    public function getChargeadministratives(): ?float
    {
        return $this->chargeadministratives;
    }

    public function setChargeadministratives(float $chargeadministratives): static
    {
        $this->chargeadministratives = $chargeadministratives;

        return $this;
    }


}
