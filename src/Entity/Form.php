<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormRepository::class)]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $creaDate;

    #[ORM\OneToOne(mappedBy: 'satisfactionForm', targetEntity: Training::class, cascade: ['persist', 'remove'])]
    private $training;

    #[ORM\OneToOne(mappedBy: 'satisfactionForm', targetEntity: Workshop::class, cascade: ['persist', 'remove'])]
    private $workshop;

    #[ORM\OneToMany(mappedBy: 'form', targetEntity: Field::class)]
    private $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
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

    public function getCreaDate(): ?\DateTimeInterface
    {
        return $this->creaDate;
    }

    public function setCreaDate(\DateTimeInterface $creaDate): self
    {
        $this->creaDate = $creaDate;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(Training $training): self
    {
        // set the owning side of the relation if necessary
        if ($training->getSatisfactionForm() !== $this) {
            $training->setSatisfactionForm($this);
        }

        $this->training = $training;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(Workshop $workshop): self
    {
        // set the owning side of the relation if necessary
        if ($workshop->getSatisfactionForm() !== $this) {
            $workshop->setSatisfactionForm($this);
        }

        $this->workshop = $workshop;

        return $this;
    }

    /**
     * @return Collection<int, Field>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(Field $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
            $field->setForm($this);
        }

        return $this;
    }

    public function removeField(Field $field): self
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getForm() === $this) {
                $field->setForm(null);
            }
        }

        return $this;
    }
}
