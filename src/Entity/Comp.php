<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comp
 *
 * @ORM\Table(name="comp")
 * @ORM\Entity
 */
class Comp
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("Produit")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     * @Groups("Produit")
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @Groups("Produit")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     * @Groups("Produit")
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     * @Groups("Produit")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     * @Groups("Produit")
     */
    private $quantite;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {

    }


    public function getReference(): ?int
    {
        return $this->reference;
    }



    public function setReference(int $reference): void
    {
        $this->reference = $reference;


    }


    public function getName(): ?string
    {
        return $this->name;
    }



    public function setName(string $name): void
    {
        $this->name = $name;

    }


    public function getImage(): ?string
    {
        return $this->image;
    }


    public function setImage(string $image): void
    {
        $this->image = $image;


    }

    public function getPrice(): ?float
    {
        return $this->price;
    }


    public function setPrice(float $price): void
    {
        $this->price = $price;


    }


    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;


    }


}
