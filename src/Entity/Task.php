<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['task:read'])]
    private int $id;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['task:read'])]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['task:read'])]
    private string $note;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['task:read'])]
    private \DateTimeInterface $date;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['task:read'])]
    private \DateTimeInterface $startTime;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups(['task:read'])]
    private \DateTimeInterface $endTime;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['task:read'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(nullable: true)]
    #[Groups(['task:read'])]
    private ?bool $isCompleted = null;

    #[ORM\Column]
    #[Groups(['task:read'])]
    private int $remind;

    #[ORM\Column(length: 255)]
    #[Groups(['task:read'])]
    private string $repetition;

    #[ORM\Column(length: 255)]
    #[Groups(['task:read'])]
    private string $color;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['task:read'])]
    private User $eagle;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department = null;

    #[ORM\Column()]
    #[Groups(['task:read'])]
    private ?bool $isPersonal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsCompleted(): ?bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(?bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getRemind(): ?int
    {
        return $this->remind;
    }

    public function setRemind(int $remind): self
    {
        $this->remind = $remind;

        return $this;
    }

    public function getRepetition(): ?string
    {
        return $this->repetition;
    }

    public function setRepetition(string $repetition): self
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getEagle(): ?User
    {
        return $this->eagle;
    }

    public function setEagle(?User $eagle): self
    {
        $this->eagle = $eagle;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function isIsPersonal(): ?bool
    {
        return $this->isPersonal;
    }

    public function setIsPersonal(?bool $isPersonal): self
    {
        $this->isPersonal = $isPersonal;

        return $this;
    }
}
