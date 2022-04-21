<?php

namespace App\Entity;

use App\Repository\BiblioIRISRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiblioIRISRepository::class)]
class BiblioIRIS
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'array', nullable: true)]
    private $files = [];

    #[ORM\OneToOne(inversedBy: 'biblioIRIS', targetEntity: Workshop::class, cascade: ['persist', 'remove'])]
    private $workshop;

    #[ORM\OneToOne(inversedBy: 'biblioIRIS', targetEntity: Training::class, cascade: ['persist', 'remove'])]
    private $training;

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
}
