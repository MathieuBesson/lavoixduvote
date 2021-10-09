<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\OneToOne(targetEntity=Candidate::class, inversedBy="program", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $programLink;

    /**
     * @ORM\ManyToMany(targetEntity=Action::class, inversedBy="programs", cascade={"persist"})
     */
    private $actions;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(Candidate $candidate): self
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getProgramLink(): ?string
    {
        return $this->programLink;
    }

    public function setProgramLink(?string $programLink): self
    {
        $this->programLink = $programLink;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        $this->actions->removeElement($action);

        return $this;
    }

    public function __toString() {
        return 'Programme de ' . $this->getCandidate()->getLastName();
    }
}
