<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe", indexes={@ORM\Index(name="capitain", columns={"capitain"})})
 * @ORM\Entity
 */
class Equipe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("Invitation")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=true)
     * @Groups("Invitation")
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="nbre_joueur", type="integer", nullable=false)
     * @Groups("Invitation")
     */
    private $nbreJoueur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logo", type="string", length=100, nullable=true)
     * @Groups("Invitation")
     */
    private $logo;

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

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return int|null
     */
    public function getNbreJoueur(): ?int
    {
        return $this->nbreJoueur;
    }

    /**
     * @param int $nbreJoueur
     */
    public function setNbreJoueur(int $nbreJoueur): void
    {
        $this->nbreJoueur = $nbreJoueur;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     */
    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    /**
     * @return \Utilisateur|null
     */
    public function getCapitain(): ?Utilisateur
    {
        return $this->capitain;
    }

    /**
     * @param \Utilisateur $capitain
     */
    public function setCapitain(Utilisateur $capitain): void
    {
        $this->capitain = $capitain;
    }

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="capitain", referencedColumnName="id")
     * })
     * @Groups("Invitation")
     */
    private $capitain;


}
