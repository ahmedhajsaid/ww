<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Matche
 *
 * @ORM\Table(name="matche", indexes={@ORM\Index(name="niveau_competition", columns={"niveau_competition"}), @ORM\Index(name="terrain", columns={"terrain"}), @ORM\Index(name="equipe1", columns={"equipe1"}), @ORM\Index(name="arbitre", columns={"arbitre"}), @ORM\Index(name="equipe2", columns={"equipe2"})})
 * @ORM\Entity
 */
class Matche
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *  @Groups("Matche")
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation(\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }


    public function getDateMatch(): ?\DateTimeInterface
    {
        return $this->dateMatch;
    }

    /**
     * @param \DateTime $dateMatch
     */
    public function setDateMatch(\DateTime $dateMatch): void
    {
        $this->dateMatch = $dateMatch;
    }

    /**
     * @return int|null
     */
    public function getResultatEq1(): ?int
    {
        return $this->resultatEq1;
    }

    /**
     * @param int|null $resultatEq1
     */
    public function setResultatEq1(?int $resultatEq1): void
    {
        $this->resultatEq1 = $resultatEq1;
    }

    /**
     * @return int|null
     */
    public function getResultatEq2(): ?int
    {
        return $this->resultatEq2;
    }

    /**
     * @param int|null $resultatEq2
     */
    public function setResultatEq2(?int $resultatEq2): void
    {
        $this->resultatEq2 = $resultatEq2;
    }

    /**
     * @return bool|null
     */
    public function getValide(): ?bool
    {
        return $this->valide;
    }

    /**
     * @param bool|null $valide
     */
    public function setValide(?bool $valide): void
    {
        $this->valide = $valide;
    }

    /**
     * @return Equipe|null
     */
    public function getEquipe1(): ?Equipe
    {
        return $this->equipe1;
    }

    /**
     * @param Equipe $equipe1
     */
    public function setEquipe1(Equipe $equipe1): void
    {
        $this->equipe1 = $equipe1;
    }

    /**
     * @return Equipe|null
     */
    public function getEquipe2(): ?Equipe
    {
        return $this->equipe2;
    }

    /**
     * @param Equipe $equipe2
     */
    public function setEquipe2(Equipe $equipe2): void
    {
        $this->equipe2 = $equipe2;
    }


    public function getNiveauCompetition(): ?NiveauCompetition
    {
        return $this->niveauCompetition;
    }


    public function setNiveauCompetition(?NiveauCompetition $niveauCompetition): self
    {
        $this->niveauCompetition = $niveauCompetition;

        return $this;
    }

    public function getTerrain(): ?Terrain
    {
        return $this->terrain;
    }

    public function setTerrain(?Terrain $terrain): self
    {
        $this->terrain = $terrain;

        return $this;
    }



    public function getArbitre(): ?Utilisateur
    {
        return $this->arbitre;
    }


    public function setArbitre(?Utilisateur $arbitre): self
    {
        $this->arbitre = $arbitre;

        return $this;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     * @Groups("Matche")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_match", type="datetime", nullable=false)
     * @Groups("Matche")
     */
    private $dateMatch;

    /**
     * @var int|null
     *
     * @ORM\Column(name="resultat_eq1", type="integer", nullable=true)
     * @Groups("Matche")
     */
    private $resultatEq1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="resultat_eq2", type="integer", nullable=true)
     * @Groups("Matche")
     */
    private $resultatEq2;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="valide", type="boolean", nullable=true)
     * @Groups("Matche")
     */
    private $valide;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe1", referencedColumnName="id")
     * })
     * @Groups("Matche")
     */
    private $equipe1;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe2", referencedColumnName="id")
     * })
     * @Groups("Matche")
     */
    private $equipe2;

    /**
     * @var \NiveauCompetition
     *
     * @ORM\ManyToOne(targetEntity="NiveauCompetition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="niveau_competition", referencedColumnName="id")
     * })
     * @Groups("Matche")
     */
    private $niveauCompetition;

    /**
     * @var \Terrain
     *
     * @ORM\ManyToOne(targetEntity="Terrain")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="terrain", referencedColumnName="id")
     * })
     * @Groups("Matche")
     */
    private $terrain;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arbitre", referencedColumnName="id")
     * })
     * @Groups("Matche")
     */
    private $arbitre;


}
