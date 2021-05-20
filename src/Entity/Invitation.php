<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Invitation
 *
 * @ORM\Table(name="invitation", indexes={@ORM\Index(name="equipe", columns={"equipe"}), @ORM\Index(name="utilisateur", columns={"utilisateur"})})
 * @ORM\Entity
 */
class Invitation
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getValide(): int
    {
        return $this->valide;
    }

    /**
     * @param int $valide
     */
    public function setValide(int $valide): void
    {
        $this->valide = $valide;
    }

    /**
     * @return \Equipe|null
     */
    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    /**
     * @param \Equipe $equipe
     */
    public function setEquipe(Equipe $equipe): void
    {
        $this->equipe = $equipe;
    }

    /**
     * @return \Utilisateur|null
     */
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * @param \Utilisateur $utilisateur
     */
    public function setUtilisateur(Utilisateur $utilisateur): void
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=200, nullable=false)
     * @Groups("Invitation")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="valide", type="integer", nullable=false)
     * @Groups("Invitation")
     */
    private $valide;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe", referencedColumnName="id")
     * })
     * @Groups("Invitation")
     */
    private $equipe;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateur", referencedColumnName="id")
     * })
     * @Groups("Invitation")
     */
    private $utilisateur;


}
