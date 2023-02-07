<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TrainingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TrainingRepository::class)]
#[ApiResource]
class Training
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['post:read'])]
    private $id;

    #[ORM\OneToOne(inversedBy: 'training', targetEntity: EngagementPost::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['library:read'])]
    private $engagementPost;

    #[ORM\ManyToMany(targetEntity: Trainer::class, mappedBy: 'Trainings')]
    #[Groups(['post:read'])]
    private $trainers;

    #[ORM\OneToOne(mappedBy: 'training', targetEntity: BiblioIRIS::class, cascade: ['persist', 'remove'])]
    private $biblioIRIS;

    #[ORM\OneToOne(inversedBy: 'training', targetEntity: Form::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $satisfactionForm;

    public function __construct()
    {
        $this->trainers = new ArrayCollection();
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

    /**
     * @return Collection<int, Trainer>
     */
    public function getTrainers(): Collection
    {
        return $this->trainers;
    }

    public function addTrainer(Trainer $trainer): self
    {
        if (!$this->trainers->contains($trainer)) {
            $this->trainers[] = $trainer;
            $trainer->addTraining($this);
        }

        return $this;
    }

    public function removeTrainer(Trainer $trainer): self
    {
        if ($this->trainers->removeElement($trainer)) {
            $trainer->removeTraining($this);
        }

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
            $this->biblioIRIS->setTraining(null);
        }

        // set the owning side of the relation if necessary
        if ($biblioIRIS !== null && $biblioIRIS->getTraining() !== $this) {
            $biblioIRIS->setTraining($this);
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
