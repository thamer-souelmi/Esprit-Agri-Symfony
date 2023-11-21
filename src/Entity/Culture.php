<?php

namespace App\Entity;

use APP\Entity\Category;
use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;

/**
 * Culture
 *
 * @ORM\Table(name="culture", indexes={@ORM\Index(name="fk_category_id", columns={"category_id"})})
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
    #[Assert\NotBlank(message: 'veuillez remplir ce champ')]
    #[Assert\Length(min: 3, minMessage: 'Le libelle doit comporter au moins {{ limit }} caractères')]
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePlantation", type="date", nullable=false)
     */
    #[Assert\NotBlank(message: 'veuillez remplir tous les champs obligatoires')]
    #[Assert\LessThan(propertyPath: "daterecolte", message: "La date de plantation doit être inférieure à la date de recolte.")]
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
    #[Assert\NotBlank(message: 'Les revenus des cultures ne peuvent pas être vides.')]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'Les revenus des cultures ne peuvent pas être négatifs.'
    )]
    private $revenuescultures;

    /**
     * @var float
     *
     * @ORM\Column(name="coutsPlantations", type="float", precision=10, scale=0, nullable=false)
     */
    #[Assert\NotBlank(message: 'Les couts des cultures ne peuvent pas être vides.')]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'Les couts des cultures ne peuvent pas être négatifs.'
    )]
    private $coutsplantations;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    // /**
    //  * @var \User
    //  *
    //  * @ORM\ManyToOne(targetEntity="User")
    //  * @ORM\JoinColumns({
    //  *   @ORM\JoinColumn(name="user_id", referencedColumnName="userId")
    //  * })
    //  */
    // private $user;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
}
