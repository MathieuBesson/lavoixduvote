<?php

namespace App\Entity;

use App\Repository\PoliticalPartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PoliticalPartyRepository::class)
 */
class PoliticalParty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siteLink;

    /**
     * @ORM\OneToOne(targetEntity=Primary::class, mappedBy="politicalParty", cascade={"persist", "remove"})
     */
    private $partyPrimary;

    /**
     * @ORM\OneToMany(targetEntity=Candidate::class, mappedBy="politicalParty")
     */
    private $candidates;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mail;

    public function __construct()
    {
        $this->candidates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getSiteLink(): ?string
    {
        return $this->siteLink;
    }

    public function setSiteLink(?string $siteLink): self
    {
        $this->siteLink = $siteLink;

        return $this;
    }

    public function getPartyPrimary(): ?Primary
    {
        return $this->partyPrimary;
    }

    public function setPartyPrimary(Primary $partyPrimary): self
    {
        // set the owning side of the relation if necessary
        if ($partyPrimary->getPoliticalParty() !== $this) {
            $partyPrimary->setPoliticalParty($this);
        }

        $this->partyPrimary = $partyPrimary;

        return $this;
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
            $candidate->setPoliticalParty($this);
        }

        return $this;
    }

    public function removeCandidate(Candidate $candidate): self
    {
        if ($this->candidates->removeElement($candidate)) {
            // set the owning side to null (unless already changed)
            if ($candidate->getPoliticalParty() === $this) {
                $candidate->setPoliticalParty(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }


}
