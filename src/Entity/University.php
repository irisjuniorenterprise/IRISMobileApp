<?php

namespace App\Entity;

use App\Repository\UniversityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UniversityRepository::class)]
class University
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'university', targetEntity: StudyField::class)]
    private $fields;

    #[ORM\OneToMany(mappedBy: 'university', targetEntity: User::class)]
    private $eagles;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->eagles = new ArrayCollection();
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

    /**
     * @return Collection<int, StudyField>
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(StudyField $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
            $field->setUniversity($this);
        }

        return $this;
    }

    public function removeField(StudyField $field): self
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getUniversity() === $this) {
                $field->setUniversity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getEagles(): Collection
    {
        return $this->eagles;
    }

    public function addEagle(User $eagle): self
    {
        if (!$this->eagles->contains($eagle)) {
            $this->eagles[] = $eagle;
            $eagle->setUniversity($this);
        }

        return $this;
    }

    public function removeEagle(User $eagle): self
    {
        if ($this->eagles->removeElement($eagle)) {
            // set the owning side to null (unless already changed)
            if ($eagle->getUniversity() === $this) {
                $eagle->setUniversity(null);
            }
        }

        return $this;
    }
}
