<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ContactAdmin{



    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstname;



    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $Lastname;



    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $Equipe;

    /**
     * @return string|null
     */
    public function getEquipe(): ?string
    {
        return $this->Equipe;
    }

    /**
     * @param string|null $Equipe
     * @return ContactAdmin
     */
    public function setEquipe(?string $Equipe): ContactAdmin
    {
        $this->Equipe = $Equipe;
        return $this;
    }


    /**
     * @var string|null
     * @Assert\NotBlank()
     *
     */
    private $phone;


    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $Email;



    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length (min=10)
     */
    private $message;

    /**
     * @var Competition|null

     */
    private $Competition;

    /**
     * @return Competition|null
     */
    public function getCompetition(): ?Competition
    {
        return $this->Competition;
    }

    /**
     * @param Competition|null $Competition
     * @return ContactAdmin
     */
    public function setCompetition(?Competition $Competition): ContactAdmin
    {
        $this->Competition = $Competition;
        return $this;
    }



    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return ContactAdmin
     */
    public function setFirstname(?string $firstname): ContactAdmin
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    /**
     * @param string|null $Lastname
     * @return ContactAdmin
     */
    public function setLastname(?string $Lastname): ContactAdmin
    {
        $this->Lastname = $Lastname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return ContactAdmin
     */
    public function setPhone(?string $phone): ContactAdmin
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    /**
     * @param string|null $Email
     * @return ContactAdmin
     */
    public function setEmail(?string $Email): ContactAdmin
    {
        $this->Email = $Email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return ContactAdmin
     */
    public function setMessage(?string $message): ContactAdmin
    {
        $this->message = $message;
        return $this;
    }



}