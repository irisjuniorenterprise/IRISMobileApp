<?php

namespace App\Entity;

use App\Repository\BlameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlameRepository::class)]
class Blame
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $reason;

    #[ORM\ManyToOne(targetEntity: Eagle::class, inversedBy: 'blames')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

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
}
