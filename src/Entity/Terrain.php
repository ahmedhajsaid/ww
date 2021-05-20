<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Terrain
 *
 * @ORM\Table(name="terrain", indexes={@ORM\Index(name="categorie", columns={"categorie"}), @ORM\Index(name="complexe", columns={"complexe"})})
   @ORM\Entity(repositoryClass="App\Repository\TerrainRepository")
 */
class Terrain
{
    /**
     * @var int
     *
     * @Groups("terrains")
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups("terrains")
     * @ORM\Column(name="designation", type="string", length=50, nullable=true)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     * @Assert\Length(min = 5, max = 50,
     * minMessage = "La désignation doit comporter au moins {{ limit }} caractères",
     * maxMessage = "La désignation doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $designation;

    /**
     * @var string|null
     *
     * @Groups("terrains")
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     * @Assert\Length(min = 5, max = 300,
     * minMessage = "La description doit comporter au moins {{ limit }} caractères",
     * maxMessage = "La description doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @Groups("terrains")
     * @ORM\Column(name="ville", type="string", length=50, nullable=true)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     */
    private $ville;

    /**
     * @var string
     *
     * @Groups("terrains")
     * @ORM\Column(name="adresse", type="string", length=100, nullable=true)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     * @Assert\Length(min = 5, max = 100,
     * minMessage = "La description doit comporter au moins {{ limit }} caractères",
     * maxMessage = "La description doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $adresse;

    /**
     * @var string|null
     *
     * @Groups("terrains")
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var bool
     *
     * @Groups("terrains")
     * @ORM\Column(name="disponible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $disponible = true;

    /**
     * @var float
     *
     * @Groups("terrains")
     * @ORM\Column(name="prix_location", type="float", precision=10, scale=0, nullable=true)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     * @Assert\Positive(message = "Le prix de location doit être positif")
     */
    private $prixLocation;

    /**
     * @var \DateTime
     *
     * @Groups("terrains")
     * @ORM\Column(name="heure_ouverture", type="time", nullable=true)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     */
    private $heureOuverture;

    /**
     * @var \DateTime
     *
     * @Groups("terrains")
     * @ORM\Column(name="heure_fermeture", type="time", nullable=true)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     */
    private $heureFermeture;

    /**
     * @var \Utilisateur
     *
     * @Groups("terrains")
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="complexe", referencedColumnName="id")
     * })
     */
    private $complexe;

    /**
     * @var \Categorie
     *
     * @Groups("terrains")
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie", referencedColumnName="id")
     * })
     */
    private $categorie;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getPrixLocation(): ?float
    {
        return $this->prixLocation;
    }

    public function setPrixLocation(float $prixLocation): self
    {
        $this->prixLocation = $prixLocation;

        return $this;
    }

    public function getHeureOuverture(): ?\DateTimeInterface
    {
        return $this->heureOuverture;
    }

    public function setHeureOuverture(\DateTimeInterface $heureOuverture): self
    {
        $this->heureOuverture = $heureOuverture;

        return $this;
    }

    public function getHeureFermeture(): ?\DateTimeInterface
    {
        return $this->heureFermeture;
    }

    public function setHeureFermeture(\DateTimeInterface $heureFermeture): self
    {
        $this->heureFermeture = $heureFermeture;

        return $this;
    }

    public function getComplexe(): ?Utilisateur
    {
        return $this->complexe;
    }

    public function setComplexe(?Utilisateur $complexe): self
    {
        $this->complexe = $complexe;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }




}
