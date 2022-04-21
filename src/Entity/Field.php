<?php

namespace App\Entity;

use App\Repository\FieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FieldRepository::class)]
class Field
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $label;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'boolean')]
    private $required;

    #[ORM\OneToOne(inversedBy: 'nextField', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private $previousField;

    #[ORM\OneToOne(mappedBy: 'previousField', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private $nextField;

    #[ORM\ManyToOne(targetEntity: Form::class, inversedBy: 'fields')]
    #[ORM\JoinColumn(nullable: false)]
    private $form;

    #[ORM\OneToMany(mappedBy: 'field', targetEntity: Option::class)]
    private $options;

    #[ORM\OneToMany(mappedBy: 'field', targetEntity: Response::class)]
    private $responses;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->responses = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getPreviousField(): ?self
    {
        return $this->previousField;
    }

    public function setPreviousField(?self $previousField): self
    {
        $this->previousField = $previousField;

        return $this;
    }

    public function getNextField(): ?self
    {
        return $this->nextField;
    }

    public function setNextField(?self $nextField): self
    {
        // unset the owning side of the relation if necessary
        if ($nextField === null && $this->nextField !== null) {
            $this->nextField->setPreviousField(null);
        }

        // set the owning side of the relation if necessary
        if ($nextField !== null && $nextField->getPreviousField() !== $this) {
            $nextField->setPreviousField($this);
        }

        $this->nextField = $nextField;

        return $this;
    }

    public function getForm(): ?Form
    {
        return $this->form;
    }

    public function setForm(?Form $form): self
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setField($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getField() === $this) {
                $option->setField(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setField($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getField() === $this) {
                $response->setField(null);
            }
        }

        return $this;
    }
}
