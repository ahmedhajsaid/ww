<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1D1C63B3E7927C74", columns={"email"})}, indexes={@ORM\Index(name="IDX_1D1C63B3BCF5E72D", columns={"categorie_id"}), @ORM\Index(name="IDX_1D1C63B36D861B89", columns={"equipe_id"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utilisateur implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $id;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     * })
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $categorie;
    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe_id", referencedColumnName="id")
     * })
     * @Groups("post:read")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     *
     *
     */
    private $equipe;


    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=180, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $email;

    /**
     * @var json|null
     *
     * @ORM\Column(name="roles", type="json", nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $roles;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
      * @Groups("Invitation")
     * @Groups("post:read")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="raison_sociale", type="string", length=255, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $raisonSociale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="matricule_fiscale", type="string", length=255, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $matriculeFiscale;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="verifie", type="boolean", nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $verifie;

    /**
     * @var int|null
     *
     * @ORM\Column(name="solde_point", type="integer", nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $soldePoint;

    /**
     * @var string|null
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $position;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $telephone;

    /**
     * @var int|null
     *
     * @ORM\Column(name="position_equipe", type="integer", nullable=true)
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $positionEquipe;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("post:read")
     * @Groups("Invitation")
     * @Groups("Penalite")
     * @Groups("PenaliteJoueur")
     * @Groups("terrains")
     */
    private $isVerified = false;

    /**
     * @return nyll/int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Categorie|null
     */
    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    /**
     * @param Categorie $categorie
     */
    public function setCategorie( Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return Equipe|null
     */
    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    /**
     * @param Equipe $equipe
     */
    public function setEquipe(Equipe $equipe): void
    {
        $this->equipe = $equipe;
    }




    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }



    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
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
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string|null $prenom
     */
    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string|null
     */
    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    /**
     * @param string|null $raisonSociale
     */
    public function setRaisonSociale(?string $raisonSociale): void
    {
        $this->raisonSociale = $raisonSociale;
    }

    /**
     * @return string|null
     */
    public function getMatriculeFiscale(): ?string
    {
        return $this->matriculeFiscale;
    }

    /**
     * @param string|null $matriculeFiscale
     */
    public function setMatriculeFiscale(?string $matriculeFiscale): void
    {
        $this->matriculeFiscale = $matriculeFiscale;
    }

    /**
     * @return bool|null
     */
    public function getVerifie(): ?bool
    {
        return $this->verifie;
    }

    /**
     * @param bool|null $verifie
     */
    public function setVerifie(?bool $verifie): void
    {
        $this->verifie = $verifie;
    }

    /**
     * @return int|null
     */
    public function getSoldePoint(): ?int
    {
        return $this->soldePoint;
    }

    /**
     * @param int|null $soldePoint
     */
    public function setSoldePoint(?int $soldePoint): void
    {
        $this->soldePoint = $soldePoint;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * @param string|null $position
     */
    public function setPosition(?string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     */
    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return int|null
     */
    public function getPositionEquipe(): ?int
    {
        return $this->positionEquipe;
    }

    /**
     * @param int|null $positionEquipe
     */
    public function setPositionEquipe(?int $positionEquipe): void
    {
        $this->positionEquipe = $positionEquipe;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }



    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }
    public function __construct()
    {


    }
    public function setrolesuser()
    {
        $this->roles = array('ROLE_USER');


    }
    public function setrolesprop()
    {
        $this->roles = array('ROLE_PROP');


    }
    public function setrolesarbitre()
    {
        $this->roles = array('ROLE_ARBITRE');


    }
    public function getRoles()
    {
        return $this->roles;
    }


}
