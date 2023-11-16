<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\AnnoncerecrutementRepository;

/**
 * Annoncerecrutement
 *
 * @ORM\Table(name="annoncerecrutement")
 * @ORM\Entity
 */
/*
@ORM\Entity(repositoryClass=AnnoncerecrutementRepository::class)
 */
class Annoncerecrutement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRecurt", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrecurt;

    /**
     * @var string
     *
     * @ORM\Column(name="posteDemande", type="string", length=255, nullable=false)
* @Assert\NotBlank(message="vueillez ajouter le poste demander")
*/
    private $postedemande;

    /**
     * @var float
     *
     * @ORM\Column(name="salairePropose", type="float", precision=10, scale=0, nullable=false)
    
* @Assert\NotBlank(message="vueillez ajouter le salaire proposer ")
*/
    private $salairepropose;

    /**
     * @var string
     *
     * @ORM\Column(name="typeContrat", type="string", length=0, nullable=false)
 
* @Assert\NotBlank(message="vueillez ajouter le type de contrat")
*/
    private $typecontrat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePub", type="date", nullable=false)
  
* @Assert\NotBlank(message="vueillez ajouter date de publication ")
*/
    private $datepub;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=false)
    
* @Assert\NotBlank(message="vueillez une localisation")
*/
    private $localisation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEmbauche", type="date", nullable=false)
   
* @Assert\NotBlank(message="vueillez ajouter date de publication")
*/
    private $dateembauche;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPosteRecherche", type="integer", nullable=false)
 
* @Assert\NotBlank(message="vueillez ajouter le nombre de poste recherché ")
*/
    private $nbposterecherche;

    /**
     * @var int|null
     *
     * @ORM\Column(name="idCandidature", type="integer", nullable=true)
 
*/
    private $idcandidature;

    public function getIdrecurt(): ?int
    {
        return $this->idrecurt;
    }

    public function getPostedemande(): ?string
    {
        return $this->postedemande;
    }

    public function setPostedemande(string $postedemande): static
    {
        $this->postedemande = $postedemande;

        return $this;
    }

    public function getSalairepropose(): ?float
    {
        return $this->salairepropose;
    }

    public function setSalairepropose(float $salairepropose): static
    {
        $this->salairepropose = $salairepropose;

        return $this;
    }

    public function getTypecontrat(): ?string
    {
        return $this->typecontrat;
    }

    public function setTypecontrat(string $typecontrat): static
    {
        $this->typecontrat = $typecontrat;

        return $this;
    }

    public function getDatepub(): ?\DateTimeInterface
    {
        return $this->datepub;
    }

    public function setDatepub(\DateTimeInterface $datepub): static
    {
        $this->datepub = $datepub;

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

    public function getDateembauche(): ?\DateTimeInterface
    {
        return $this->dateembauche;
    }

    public function setDateembauche(\DateTimeInterface $dateembauche): static
    {
        $this->dateembauche = $dateembauche;

        return $this;
    }

    public function getNbposterecherche(): ?int
    {
        return $this->nbposterecherche;
    }

    public function setNbposterecherche(int $nbposterecherche): static
    {
        $this->nbposterecherche = $nbposterecherche;

        return $this;
    }

    public function getIdcandidature(): ?int
    {
        return $this->idcandidature;
    }

    public function setIdcandidature(?int $idcandidature): static
    {
        $this->idcandidature = $idcandidature;

        return $this;
    }


}
