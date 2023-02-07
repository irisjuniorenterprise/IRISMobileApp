<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EngagementPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EngagementPostRepository::class)]
#[ApiResource]
class EngagementPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['post:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['post:read'])]
    private $place;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['post:read'])]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['post:read'])]
    private $link;

    #[ORM\Column(type: 'datetime')]
    private $start;

    #[ORM\Column(type: 'datetime')]
    private $end;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $canceled;

    #[ORM\OneToOne(inversedBy: 'engagementPost', targetEntity: Post::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['library:read'])]
    private $post;

    #[ORM\OneToMany(mappedBy: 'engagementPost', targetEntity: Attendance::class)]
    private $attendances;

    #[ORM\OneToMany(mappedBy: 'engagementPost', targetEntity: AttendanceApproval::class)]
    private $attendanceApprovals;

    #[ORM\OneToMany(mappedBy: 'engagementPost', targetEntity: AttendanceDisapproval::class)]
    private $attendanceDisapprovals;

    #[ORM\OneToOne(mappedBy: 'engagementPost', targetEntity: WorkPost::class, cascade: ['persist', 'remove'])]
    #[Groups(['post:read'])]
    private $workPost;

    #[ORM\OneToOne(mappedBy: 'engagementPost', targetEntity: Training::class, cascade: ['persist', 'remove'])]
    #[Groups(['post:read'])]
    private $training;

    public function __construct()
    {
        $this->attendances = new ArrayCollection();
        $this->attendanceApprovals = new ArrayCollection();
        $this->attendanceDisapprovals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getCanceled(): ?bool
    {
        return $this->canceled;
    }

    public function setCanceled(?bool $canceled): self
    {
        $this->canceled = $canceled;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Collection<int, Attendance>
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setEngagementPost($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getEngagementPost() === $this) {
                $attendance->setEngagementPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttendanceApproval>
     */
    public function getAttendanceApprovals(): Collection
    {
        return $this->attendanceApprovals;
    }

    public function addAttendanceApproval(AttendanceApproval $attendanceApproval): self
    {
        if (!$this->attendanceApprovals->contains($attendanceApproval)) {
            $this->attendanceApprovals[] = $attendanceApproval;
            $attendanceApproval->setEngagementPost($this);
        }

        return $this;
    }

    public function removeAttendanceApproval(AttendanceApproval $attendanceApproval): self
    {
        if ($this->attendanceApprovals->removeElement($attendanceApproval)) {
            // set the owning side to null (unless already changed)
            if ($attendanceApproval->getEngagementPost() === $this) {
                $attendanceApproval->setEngagementPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttendanceDisapproval>
     */
    public function getAttendanceDisapprovals(): Collection
    {
        return $this->attendanceDisapprovals;
    }

    public function addAttendanceDisapproval(AttendanceDisapproval $attendanceDisapproval): self
    {
        if (!$this->attendanceDisapprovals->contains($attendanceDisapproval)) {
            $this->attendanceDisapprovals[] = $attendanceDisapproval;
            $attendanceDisapproval->setEngagementPost($this);
        }

        return $this;
    }

    public function removeAttendanceDisapproval(AttendanceDisapproval $attendanceDisapproval): self
    {
        if ($this->attendanceDisapprovals->removeElement($attendanceDisapproval)) {
            // set the owning side to null (unless already changed)
            if ($attendanceDisapproval->getEngagementPost() === $this) {
                $attendanceDisapproval->setEngagementPost(null);
            }
        }

        return $this;
    }

    public function getWorkPost(): ?WorkPost
    {
        return $this->workPost;
    }

    public function setWorkPost(WorkPost $workPost): self
    {
        // set the owning side of the relation if necessary
        if ($workPost->getEngagementPost() !== $this) {
            $workPost->setEngagementPost($this);
        }

        $this->workPost = $workPost;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(Training $training): self
    {
        // set the owning side of the relation if necessary
        if ($training->getEngagementPost() !== $this) {
            $training->setEngagementPost($this);
        }

        $this->training = $training;

        return $this;
    }
}
