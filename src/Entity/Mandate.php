<?php

namespace App\Entity;

use App\Repository\MandateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MandateRepository::class)]
class Mandate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $start;

    #[ORM\OneToOne(inversedBy: 'previous', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private $next;

    #[ORM\OneToOne(mappedBy: 'next', targetEntity: self::class, cascade: ['persist', 'remove'])]
    private $previous;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getNext(): ?self
    {
        return $this->next;
    }

    public function setNext(?self $next): self
    {
        $this->next = $next;

        return $this;
    }

    public function getPrevious(): ?self
    {
        return $this->previous;
    }

    public function setPrevious(?self $previous): self
    {
        // unset the owning side of the relation if necessary
        if ($previous === null && $this->previous !== null) {
            $this->previous->setNext(null);
        }

        // set the owning side of the relation if necessary
        if ($previous !== null && $previous->getNext() !== $this) {
            $previous->setNext($this);
        }

        $this->previous = $previous;

        return $this;
    }
}
