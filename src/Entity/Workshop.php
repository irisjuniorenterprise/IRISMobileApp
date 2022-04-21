<?php

namespace App\Entity;

use App\Repository\WorkshopRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkshopRepository::class)]
class Workshop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'workshop', targetEntity: WorkPost::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $workPost;

    #[ORM\OneToOne(mappedBy: 'workshop', targetEntity: BiblioIRIS::class, cascade: ['persist', 'remove'])]
    private $biblioIRIS;

    #[ORM\OneToOne(inversedBy: 'workshop', targetEntity: Form::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $satisfactionForm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkPost(): ?WorkPost
    {
        return $this->workPost;
    }

    public function setWorkPost(WorkPost $workPost): self
    {
        $this->workPost = $workPost;

        return $this;
    }

    public function getBiblioIRIS(): ?BiblioIRIS
    {
        return $this->biblioIRIS;
    }

    public function setBiblioIRIS(?BiblioIRIS $biblioIRIS): self
    {
        // unset the owning side of the relation if necessary
        if ($biblioIRIS === null && $this->biblioIRIS !== null) {
            $this->biblioIRIS->setWorkshop(null);
        }

        // set the owning side of the relation if necessary
        if ($biblioIRIS !== null && $biblioIRIS->getWorkshop() !== $this) {
            $biblioIRIS->setWorkshop($this);
        }

        $this->biblioIRIS = $biblioIRIS;

        return $this;
    }

    public function getSatisfactionForm(): ?Form
    {
        return $this->satisfactionForm;
    }

    public function setSatisfactionForm(Form $satisfactionForm): self
    {
        $this->satisfactionForm = $satisfactionForm;

        return $this;
    }
}
