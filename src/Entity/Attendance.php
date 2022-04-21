<?php

namespace App\Entity;

use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceRepository::class)]
class Attendance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $attendance;

    #[ORM\ManyToOne(targetEntity: Eagle::class, inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

    #[ORM\ManyToOne(targetEntity: EngagementPost::class, inversedBy: 'attendances')]
    #[ORM\JoinColumn(nullable: false)]
    private $engagementPost;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttendance(): ?bool
    {
        return $this->attendance;
    }

    public function setAttendance(bool $attendance): self
    {
        $this->attendance = $attendance;

        return $this;
    }

    public function getEagle(): ?Eagle
    {
        return $this->eagle;
    }

    public function setEagle(?Eagle $eagle): self
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
