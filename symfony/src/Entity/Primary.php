<?php

namespace App\Entity;

use App\Repository\PrimaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrimaryRepository::class)
 * @ORM\Table(name="`primary`")
 */
class Primary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Candidate::class, mappedBy="partyPrimary")
     */
    private $candidates;

    /**
     * @ORM\OneToOne(targetEntity=PoliticalParty::class, inversedBy="partyPrimary", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $politicalParty;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFirstRound;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSecondRound;

    public function __construct()
    {
        $this->candidates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Candidate[]
     */
    public function getCandidates(): Collection
    {
        return $this->candidates;
    }

    public function addCandidate(Candidate $candidate): self
    {
        if (!$this->candidates->contains($candidate)) {
            $this->candidates[] = $candidate;
            $candidate->setPartyPrimary($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        if ($this->candidates->removeElement($candidate)) {
            // set the owning side to null (unless already changed)
            if ($candidate->getPartyPrimary() === $this) {
                $candidate->setPartyPrimary(null);
            }
        }

        return $this;
    }

    public function getPoliticalParty(): ?PoliticalParty
    {
        return $this->politicalParty;
    }

    public function setPoliticalParty(PoliticalParty $politicalParty): self
    {
        $this->politicalParty = $politicalParty;

        return $this;
    }

    public function getDateFirstRound(): ?\DateTimeInterface
    {
        return $this->dateFirstRound;
    }

    public function setDateFirstRound(?\DateTimeInterface $dateFirstRound): self
    {
        $this->dateFirstRound = $dateFirstRound;

        return $this;
    }

    public function getDateSecondRound(): ?\DateTimeInterface
    {
        return $this->dateSecondRound;
    }

    public function setDateSecondRound(?\DateTimeInterface $dateSecondRound): self
    {
        $this->dateSecondRound = $dateSecondRound;

        return $this;
    }
}
