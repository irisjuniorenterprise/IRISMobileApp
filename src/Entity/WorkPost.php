<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WorkPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WorkPostRepository::class)]
#[ApiResource]
class WorkPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'workPost', targetEntity: EngagementPost::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['library:read'])]
    private $engagementPost;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'workPosts')]
    #[ORM\JoinColumn(nullable: false)]
    private $sg;

    #[ORM\OneToMany(mappedBy: 'workPost', targetEntity: Agenda::class)]
    private $agendas;

    #[ORM\OneToOne(mappedBy: 'workPost', targetEntity: Meeting::class, cascade: ['persist', 'remove'])]
    #[Groups(['post:read'])]
    private $meeting;

    #[ORM\OneToOne(mappedBy: 'workPost', targetEntity: Workshop::class, cascade: ['persist', 'remove'])]
    #[Groups(['post:read'])]
    private $workshop;

    public function __construct()
    {
        $this->agendas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEngagementPost(): ?EngagementPost
    {
        return $this->engagementPost;
    }

    public function setEngagementPost(EngagementPost $engagementPost): self
    {
        $this->engagementPost = $engagementPost;

        return $this;
    }

    public function getSg(): ?User
    {
        return $this->sg;
    }

    public function setSg(?User $sg): self
    {
        $this->sg = $sg;

        return $this;
    }

    /**
     * @return Collection<int, Agenda>
     */
    public function getAgendas(): Collection
    {
        return $this->agendas;
    }

    public function addAgenda(Agenda $agenda): self
    {
        if (!$this->agendas->contains($agenda)) {
            $this->agendas[] = $agenda;
            $agenda->setWorkPost($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agendas->removeElement($agenda)) {
            // set the owning side to null (unless already changed)
            if ($agenda->getWorkPost() === $this) {
                $agenda->setWorkPost(null);
            }
        }

        return $this;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(Meeting $meeting): self
    {
        // set the owning side of the relation if necessary
        if ($meeting->getWorkPost() !== $this) {
            $meeting->setWorkPost($this);
        }

        $this->meeting = $meeting;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(Workshop $workshop): self
    {
        // set the owning side of the relation if necessary
        if ($workshop->getWorkPost() !== $this) {
            $workshop->setWorkPost($this);
        }

        $this->workshop = $workshop;

        return $this;
    }
}
