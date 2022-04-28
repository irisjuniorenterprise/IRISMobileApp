<?php

namespace App\Entity;

use App\Repository\PollOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PollOptionRepository::class)]
class PollOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $value;

    #[ORM\ManyToOne(targetEntity: Poll::class, inversedBy: 'pollOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $poll;

    #[ORM\OneToMany(mappedBy: 'pollOption', targetEntity: Polling::class)]
    private $pollings;

    public function __construct()
    {
        $this->pollings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function setPoll(?Poll $poll): self
    {
        $this->poll = $poll;

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
            $polling->setPollOption($this);
        }

        return $this;
    }

    public function removePolling(Polling $polling): self
    {
        if ($this->pollings->removeElement($polling)) {
            // set the owning side to null (unless already changed)
            if ($polling->getPollOption() === $this) {
                $polling->setPollOption(null);
            }
        }

        return $this;
    }
}
