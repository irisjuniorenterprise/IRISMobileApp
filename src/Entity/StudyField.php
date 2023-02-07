<?php

namespace App\Entity;

use App\Repository\StudyFieldRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudyFieldRepository::class)]
class StudyField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $field;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'fields')]
    #[ORM\JoinColumn(nullable: false)]
    private $university;

    #[ORM\OneToMany(mappedBy: 'studyField', targetEntity: User::class)]
    private $eagles;

    public function __construct()
    {
        $this->eagles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): self
    {
        $this->university = $university;

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
            $eagle->setStudyField($this);
        }

        return $this;
    }

    public function removeEagle(User $eagle): self
    {
        if ($this->eagles->removeElement($eagle)) {
            // set the owning side to null (unless already changed)
            if ($eagle->getStudyField() === $this) {
                $eagle->setStudyField(null);
            }
        }

        return $this;
    }
}
