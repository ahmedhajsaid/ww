<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Penalite
 *
 * @ORM\Table(name="penalite", indexes={@ORM\Index(name="penalite_ibfk_1", columns={"complexe"})})
 * @ORM\Entity(repositoryClass="App\Repository\PenaliteRepository")
 */
class Penalite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=30, nullable=false)
     * @Assert\NotNull(message = "Ce champs est obligatoire")
     * @Assert\Length(min = 5, max = 50,
     * minMessage = "La désignation doit comporter au moins {{ limit }} caractères",
     * maxMessage = "La désignation doit comporter au plus {{ limit }} caractères"
     * )
     *
     */
    private $designation;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_points_retires", type="integer", nullable=false)
     * @Assert\Positive(message = "Le nombre des points doit être positif")
     *
     */
    private $nbrePointsRetires;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="complexe", referencedColumnName="id")
     *
     * })
     */
    private $complexe;

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

    public function getNbrePointsRetires(): ?int
    {
        return $this->nbrePointsRetires;
    }

    public function setNbrePointsRetires(int $nbrePointsRetires): self
    {
        $this->nbrePointsRetires = $nbrePointsRetires;

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

}