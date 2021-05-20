<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * PenaliteJoueur
 *
 * @ORM\Table(name="penalite_joueur", indexes={@ORM\Index(name="arbitre", columns={"arbitre"}), @ORM\Index(name="joueur", columns={"joueur"}), @ORM\Index(name="matche", columns={"matche"}), @ORM\Index(name="penalite", columns={"penalite"})})
 * @ORM\Entity(repositoryClass="App\Repository\PenaliteJoueurRepository")
 */
class PenaliteJoueur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("PenaliteJoueur")
     *
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=true)
     * @Groups("PenaliteJoueur")
     * @Groups("searchPenaliteJ")
     */
    private $heure;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="arbitre", referencedColumnName="id")
     * })
     * @Groups("searchPenaliteJ")
     */
    private $arbitre;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="joueur", referencedColumnName="id")
     * })
     * @Groups("PenaliteJoueur")
     * @Groups("searchPenaliteJ")
     */
    private $joueur;

    /**
     * @var \Matche
     *
     * @ORM\ManyToOne(targetEntity="Matche")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matche", referencedColumnName="id")
     * })
     * @Groups("PenaliteJoueur")
     * @Groups("searchPenaliteJ")
     */
    private $matche;

    /**
     * @var \Penalite
     *
     * @ORM\ManyToOne(targetEntity="Penalite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="penalite", referencedColumnName="id")
     * })
     * @Groups("PenaliteJoueur")
     * @Groups("searchPenaliteJ")
     */
    private $penalite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

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

    public function getJoueur(): ?Utilisateur
    {
        return $this->joueur;
    }

    public function setJoueur(?Utilisateur $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }

    public function getMatche(): ?Matche
    {
        return $this->matche;
    }

    public function setMatche(?Matche $matche): self
    {
        $this->matche = $matche;

        return $this;
    }

    public function getPenalite(): ?Penalite
    {
        return $this->penalite;
    }

    public function setPenalite(?Penalite $penalite): self
    {
        $this->penalite = $penalite;

        return $this;
    }


}
