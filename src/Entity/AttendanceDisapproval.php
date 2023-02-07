<?php

namespace App\Entity;

use App\Repository\AttendanceDisapprovalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceDisapprovalRepository::class)]
class AttendanceDisapproval
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'text')]
    private $justification;

    #[ORM\Column(type: 'array')]
    private $files = [];

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'attendanceDisapprovals')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

    #[ORM\ManyToOne(targetEntity: EngagementPost::class, inversedBy: 'attendanceDisapprovals')]
    #[ORM\JoinColumn(nullable: false)]
    private $engagementPost;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getJustification(): ?string
    {
        return $this->justification;
    }

    public function setJustification(string $justification): self
    {
        $this->justification = $justification;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(array $files): self
    {
        $this->files = $files;

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

    public function getEngagementPost(): ?EngagementPost
    {
        return $this->engagementPost;
    }

    public function setEngagementPost(?EngagementPost $engagementPost): self
    {
        $this->engagementPost = $engagementPost;

        return $this;
    }
}
