<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NiveauCompetition
 *
 * @ORM\Table(name="niveau_competition", indexes={@ORM\Index(name="competition", columns={"competition"})})
 * @ORM\Entity
 */
class NiveauCompetition
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
     * @ORM\Column(name="designation", type="string", length=100, nullable=false)
     */
    private $designation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \Competition
     *
     * @ORM\ManyToOne(targetEntity="Competition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="competition", referencedColumnName="id")
     * })
     */
    private $competition;


}
