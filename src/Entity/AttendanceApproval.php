<?php

namespace App\Entity;

use App\Repository\AttendanceApprovalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceApprovalRepository::class)]
class AttendanceApproval
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'attendanceApprovals')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

    #[ORM\ManyToOne(targetEntity: EngagementPost::class, inversedBy: 'attendanceApprovals')]
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
