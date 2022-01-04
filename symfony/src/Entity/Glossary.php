<?php

namespace App\Entity;

use App\Repository\GlossaryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GlossaryRepository::class)
 */
class Glossary
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
    private $word;

    /**
     * @ORM\Column(type="text")
     */
    private $definition;

    /**
     * @ORM\ManyToOne(targetEntity=GlossaryCategory::class, inversedBy="glossaries")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $source;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWord(): ?string
    {
        return $this->word;
    }

    public function setWord(string $word): self
    {
        $this->word = $word;

        return $this;
    }

    public function getDefinition(): ?string
    {
        return $this->definition;
    }

    public function setDefinition(string $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function getCategory(): ?GlossaryCategory
    {
        return $this->category;
    }

    public function setCategory(?GlossaryCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function __toString() {
        return $this->word;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
