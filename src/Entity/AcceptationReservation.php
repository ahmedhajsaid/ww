<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AcceptationReservation
 *
 * @ORM\Table(name="acceptation_reservation", indexes={@ORM\Index(name="client", columns={"client"}), @ORM\Index(name="reservation", columns={"reservation"})})
 * @ORM\Entity(repositoryClass="App\Repository\AcceptationReservationRepository")
 */
class AcceptationReservation
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
     * @var bool|null
     *
     * @ORM\Column(name="acceptee", type="boolean", nullable=true)
     */
    private $acceptee;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="id")
     * })
     */
    private $client;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation", referencedColumnName="id")
     * })
     */
    private $reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAcceptee(): ?bool
    {
        return $this->acceptee;
    }

    public function setAcceptee(?bool $acceptee): self
    {
        $this->acceptee = $acceptee;

        return $this;
    }

    public function getClient(): ?Utilisateur
    {
        return $this->client;
    }

    public function setClient(?Utilisateur $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }


}
