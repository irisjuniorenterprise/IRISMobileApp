<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BiblioIRISRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BiblioIRISRepository::class)]

#[ApiResource]
class BiblioIRIS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    #[Groups(['library:read'])]
    private $content;

    #[ORM\Column(type: 'array', nullable: true)]
    #[Groups(['library:read'])]
    private $files = [];

    #[ORM\OneToOne(inversedBy: 'biblioIRIS', targetEntity: Workshop::class, cascade: ['persist', 'remove'])]
    #[Groups(['library:read'])]
    private $workshop;

    #[ORM\OneToOne(inversedBy: 'biblioIRIS', targetEntity: Training::class, cascade: ['persist', 'remove'])]
    #[Groups(['library:read'])]
    private $training;

    #[ORM\ManyToOne(inversedBy: 'biblioIRIS')]
    private ?User $postedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): self
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getPostedBy(): ?User
    {
        return $this->postedBy;
    }

    public function setPostedBy(?User $postedBy): self
    {
        $this->postedBy = $postedBy;

        return $this;
    }
}
