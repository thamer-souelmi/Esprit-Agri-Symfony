<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "bilancomptable")]
#[ORM\Entity]
class Bilancomptable
{
    #[ORM\Column(name: "idBilanC", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $idbilanc;

    #[ORM\Column(name: "idUser", type: "integer", nullable: false)]
    private $iduser;

    #[ORM\Column(name: "annee", type: "date", nullable: false)]
    private $annee;

    #[ORM\Column(name: "resultatNet", type: "float", precision: 10, scale: 0, nullable: false)]
    private $resultatnet;

    #[ORM\Column(name: "valeurTerrain", type: "float", precision: 10, scale: 0, nullable: false)]
    private $valeurterrain;

    #[ORM\Column(name: "materiels", type: "float", precision: 10, scale: 0, nullable: false)]
    private $materiels;

    #[ORM\Column(name: "autresImmobilisations", type: "float", precision: 10, scale: 0, nullable: false)]
    private $autresimmobilisations;

    #[ORM\Column(name: "stocksProduits", type: "float", precision: 10, scale: 0, nullable: false)]
    private $stocksproduits;

    #[ORM\Column(name: "creanceClient", type: "float", precision: 10, scale: 0, nullable: false)]
    private $creanceclient;

    #[ORM\Column(name: "tresorie", type: "float", precision: 10, scale: 0, nullable: false)]
    private $tresorie;

    #[ORM\Column(name: "capitalSocial", type: "float", precision: 10, scale: 0, nullable: false)]
    private $capitalsocial;

    #[ORM\Column(name: "reserves", type: "float", precision: 10, scale: 0, nullable: false)]
    private $reserves;

    #[ORM\Column(name: "emprunts", type: "float", precision: 10, scale: 0, nullable: false)]
    private $emprunts;

    #[ORM\Column(name: "dettesCT", type: "float", precision: 10, scale: 0, nullable: false)]
    private $dettesct;

    #[ORM\Column(name: "dettesIT", type: "float", precision: 10, scale: 0, nullable: false)]
    private $dettesit;

    #[ORM\Column(name: "fournisseurs", type: "float", precision: 10, scale: 0, nullable: false)]
    private $fournisseurs;

    public function getIdbilanc(): ?int
    {
        return $this->idbilanc;
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

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getResultatnet(): ?float
    {
        return $this->resultatnet;
    }

    public function setResultatnet(float $resultatnet): static
    {
        $this->resultatnet = $resultatnet;

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

    public function getMateriels(): ?float
    {
        return $this->materiels;
    }

    public function setMateriels(float $materiels): static
    {
        $this->materiels = $materiels;

        return $this;
    }

    public function getAutresimmobilisations(): ?float
    {
        return $this->autresimmobilisations;
    }

    public function setAutresimmobilisations(float $autresimmobilisations): static
    {
        $this->autresimmobilisations = $autresimmobilisations;

        return $this;
    }

    public function getStocksproduits(): ?float
    {
        return $this->stocksproduits;
    }

    public function setStocksproduits(float $stocksproduits): static
    {
        $this->stocksproduits = $stocksproduits;

        return $this;
    }

    public function getCreanceclient(): ?float
    {
        return $this->creanceclient;
    }

    public function setCreanceclient(float $creanceclient): static
    {
        $this->creanceclient = $creanceclient;

        return $this;
    }

    public function getTresorie(): ?float
    {
        return $this->tresorie;
    }

    public function setTresorie(float $tresorie): static
    {
        $this->tresorie = $tresorie;

        return $this;
    }

    public function getCapitalsocial(): ?float
    {
        return $this->capitalsocial;
    }

    public function setCapitalsocial(float $capitalsocial): static
    {
        $this->capitalsocial = $capitalsocial;

        return $this;
    }

    public function getReserves(): ?float
    {
        return $this->reserves;
    }

    public function setReserves(float $reserves): static
    {
        $this->reserves = $reserves;

        return $this;
    }

    public function getEmprunts(): ?float
    {
        return $this->emprunts;
    }

    public function setEmprunts(float $emprunts): static
    {
        $this->emprunts = $emprunts;

        return $this;
    }

    public function getDettesct(): ?float
    {
        return $this->dettesct;
    }

    public function setDettesct(float $dettesct): static
    {
        $this->dettesct = $dettesct;

        return $this;
    }

    public function getDettesit(): ?float
    {
        return $this->dettesit;
    }

    public function setDettesit(float $dettesit): static
    {
        $this->dettesit = $dettesit;

        return $this;
    }

    public function getFournisseurs(): ?float
    {
        return $this->fournisseurs;
    }

    public function setFournisseurs(float $fournisseurs): static
    {
        $this->fournisseurs = $fournisseurs;

        return $this;
    }


}
