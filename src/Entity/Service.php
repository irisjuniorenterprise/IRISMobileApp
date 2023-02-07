<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToMany(targetEntity: PriceProposal::class, mappedBy: 'service')]
    private Collection $priceProposals;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ServiceFeature::class)]
    private Collection $serviceFeature;

    #[ORM\ManyToOne(targetEntity: Department::class, inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Department $department;

    public function __construct()
    {
        $this->priceProposals = new ArrayCollection();
        $this->serviceFeature = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, PriceProposal>
     */
    public function getPriceProposals(): Collection
    {
        return $this->priceProposals;
    }

    public function addPriceProposal(PriceProposal $priceProposal): self
    {
        if (!$this->priceProposals->contains($priceProposal)) {
            $this->priceProposals[] = $priceProposal;
            $priceProposal->addService($this);
        }

        return $this;
    }

    public function removePriceProposal(PriceProposal $priceProposal): self
    {
        if ($this->priceProposals->removeElement($priceProposal)) {
            $priceProposal->removeService($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ServiceFeature>
     */
    public function getServiceFeature(): Collection
    {
        return $this->serviceFeature;
    }

    public function addServiceFeature(ServiceFeature $serviceFeature): self
    {
        if (!$this->serviceFeature->contains($serviceFeature)) {
            $this->serviceFeature[] = $serviceFeature;
            $serviceFeature->setService($this);
        }

        return $this;
    }

    public function removeServiceFeature(ServiceFeature $serviceFeature): self
    {
        if ($this->serviceFeature->removeElement($serviceFeature)) {
            // set the owning side to null (unless already changed)
            if ($serviceFeature->getService() === $this) {
                $serviceFeature->setService(null);
            }
        }

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }
}
