<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PollRepository::class)]
#[ApiResource]
class Poll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['post:read'])]
    private $id;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['post:read'])]
    private $end;

    #[ORM\OneToOne(inversedBy: 'poll', targetEntity: Post::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $post;

    #[ORM\OneToMany(mappedBy: 'poll', targetEntity: PollOption::class)]
    #[Groups(['post:read'])]
    private $pollOptions;

    #[ORM\OneToMany(mappedBy: 'poll', targetEntity: Polling::class)]
    private $pollings;

    public function __construct()
    {
        $this->pollOptions = new ArrayCollection();
        $this->pollings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, PollOption>
     */
    public function getPollOptions(): Collection
    {
        return $this->pollOptions;
    }

    public function addPollOption(PollOption $pollOption): self
    {
        if (!$this->pollOptions->contains($pollOption)) {
            $this->pollOptions[] = $pollOption;
            $pollOption->setPoll($this);
        }

        return $this;
    }

    public function removePollOption(PollOption $pollOption): self
    {
        if ($this->pollOptions->removeElement($pollOption)) {
            // set the owning side to null (unless already changed)
            if ($pollOption->getPoll() === $this) {
                $pollOption->setPoll(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Polling>
     */
    public function getPollings(): Collection
    {
        return $this->pollings;
    }

    public function addPolling(Polling $polling): self
    {
        if (!$this->pollings->contains($polling)) {
            $this->pollings[] = $polling;
            $polling->setPoll($this);
        }

        return $this;
    }

    public function removePolling(Polling $polling): self
    {
        if ($this->pollings->removeElement($polling)) {
            // set the owning side to null (unless already changed)
            if ($polling->getPoll() === $this) {
                $polling->setPoll(null);
            }
        }

        return $this;
    }
}
