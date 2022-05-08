<?php

namespace App\Entity;

use App\Repository\PriceProposalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceProposalRepository::class)]
class PriceProposal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $object;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $creation_date;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $currency;

    #[ORM\ManyToOne(targetEntity: Discount::class, inversedBy: 'priceProposals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Discount $discount;

    #[ORM\ManyToOne(targetEntity: Prospect::class, inversedBy: 'priceProposals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prospect $prospect;

    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'priceProposals')]
    private ArrayCollection $service;

    #[ORM\OneToMany(mappedBy: 'priceProposal', targetEntity: PriceProposalFeature::class)]
    private ArrayCollection $priceProposalFeature;

    public function __construct()
    {
        $this->service = new ArrayCollection();
        $this->priceProposalFeature = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscount(?Discount $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getProspect(): ?Prospect
    {
        return $this->prospect;
    }

    public function setProspect(?Prospect $prospect): self
    {
        $this->prospect = $prospect;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->service->removeElement($service);

        return $this;
    }

    /**
     * @return Collection<int, PriceProposalFeature>
     */
    public function getPriceProposalFeature(): Collection
    {
        return $this->priceProposalFeature;
    }

    public function addPriceProposalFeature(PriceProposalFeature $priceProposalFeature): self
    {
        if (!$this->priceProposalFeature->contains($priceProposalFeature)) {
            $this->priceProposalFeature[] = $priceProposalFeature;
            $priceProposalFeature->setPriceProposal($this);
        }

        return $this;
    }

    public function removePriceProposalFeature(PriceProposalFeature $priceProposalFeature): self
    {
        if ($this->priceProposalFeature->removeElement($priceProposalFeature)) {
            // set the owning side to null (unless already changed)
            if ($priceProposalFeature->getPriceProposal() === $this) {
                $priceProposalFeature->setPriceProposal(null);
            }
        }

        return $this;
    }
}
