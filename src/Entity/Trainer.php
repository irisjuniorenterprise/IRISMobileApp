<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TrainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TrainerRepository::class)]
#[ApiResource]
class Trainer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['post:read'])]
    private $fName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['post:read'])]
    private $lName;

    #[ORM\ManyToMany(targetEntity: Training::class, inversedBy: 'trainers')]
    private $Trainings;

    public function __construct()
    {
        $this->Trainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFName(): ?string
    {
        return $this->fName;
    }

    public function setFName(string $fName): self
    {
        $this->fName = $fName;

        return $this;
    }

    public function getLName(): ?string
    {
        return $this->lName;
    }

    public function setLName(string $lName): self
    {
        $this->lName = $lName;

        return $this;
    }

    /**
     * @return Collection<int, Training>
     */
    public function getTrainings(): Collection
    {
        return $this->Trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->Trainings->contains($training)) {
            $this->Trainings[] = $training;
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        $this->Trainings->removeElement($training);

        return $this;
    }
}
