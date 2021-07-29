<?php

namespace App\Entity;

use App\Repository\GlossaryCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GlossaryCategoryRepository::class)
 */
class GlossaryCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Glossary::class, mappedBy="category")
     */
    private $glossaries;

    public function __construct()
    {
        $this->glossaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|Glossary[]
     */
    public function getGlossaries(): Collection
    {
        return $this->glossaries;
    }

    public function addGlossary(Glossary $glossary): self
    {
        if (!$this->glossaries->contains($glossary)) {
            $this->glossaries[] = $glossary;
            $glossary->setCategory($this);
        }

        return $this;
    }

    public function removeGlossary(Glossary $glossary): self
    {
        if ($this->glossaries->removeElement($glossary)) {
            // set the owning side to null (unless already changed)
            if ($glossary->getCategory() === $this) {
                $glossary->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }
}
