<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToOne(targetEntity=Program::class, mappedBy="candidate", cascade={"persist", "remove"})
     */
    private $program;

    /**
     * @ORM\OneToMany(targetEntity=StarMeasure::class, mappedBy="candidate", orphanRemoval=true)
     */
    private $starMeasures;

    public function __construct()
    {
        $this->starMeasures = new ArrayCollection();
    }

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

    public function displayPicture(): ?string
    {
        return '/uploads/candidates/' . $this->picture;
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

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): self
    {
        // set the owning side of the relation if necessary
        if ($program->getCandidate() !== $this) {
            $program->setCandidate($this);
        }

        $this->program = $program;

        return $this;
    }

    public function __toString() {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return Collection|StarMeasure[]
     */
    public function getStarMeasures(): Collection
    {
        return $this->starMeasures;
    }

    public function addStarMeasure(StarMeasure $starMeasure): self
    {
        if (!$this->starMeasures->contains($starMeasure)) {
            $this->starMeasures[] = $starMeasure;
            $starMeasure->setCandidate($this);
        }

        return $this;
    }

    public function removeStarMeasure(StarMeasure $starMeasure): self
    {
        if ($this->starMeasures->removeElement($starMeasure)) {
            // set the owning side to null (unless already changed)
            if ($starMeasure->getCandidate() === $this) {
                $starMeasure->setCandidate(null);
            }
        }

        return $this;
    }

}
