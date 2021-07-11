<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidateRepository::class)
 */
class Candidate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    /**
     * @ORM\Column(type="boolean")
     */
    private $electedByPrimary;

    /**
     * @ORM\Column(type="boolean")
     */
    private $secondRoundElections;

    /**
     * @ORM\ManyToOne(targetEntity=Primary::class, inversedBy="candidates")
     */
    private $partyPrimary;

    /**
     * @ORM\ManyToOne(targetEntity=PoliticalParty::class, inversedBy="candidates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $politicalParty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getElectedByPrimary(): ?bool
    {
        return $this->electedByPrimary;
    }

    public function setElectedByPrimary(bool $electedByPrimary): self
    {
        $this->electedByPrimary = $electedByPrimary;

        return $this;
    }

    public function getSecondRoundElections(): ?bool
    {
        return $this->secondRoundElections;
    }

    public function setSecondRoundElections(bool $secondRoundElections): self
    {
        $this->secondRoundElections = $secondRoundElections;

        return $this;
    }

    public function getPartyPrimary(): ?Primary
    {
        return $this->partyPrimary;
    }

    public function setPartyPrimary(?Primary $partyPrimary): self
    {
        $this->partyPrimary = $partyPrimary;

        return $this;
    }

    public function getPoliticalParty(): ?PoliticalParty
    {
        return $this->politicalParty;
    }

    public function setPoliticalParty(?PoliticalParty $politicalParty): self
    {
        $this->politicalParty = $politicalParty;

        return $this;
    }
}
