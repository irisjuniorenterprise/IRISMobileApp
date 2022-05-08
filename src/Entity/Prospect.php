<?php

namespace App\Entity;

use App\Repository\ProspectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProspectRepository::class)]
class Prospect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $agent;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $phone;

    #[ORM\OneToMany(mappedBy: 'prospect', targetEntity: PriceProposal::class)]
    private ArrayCollection $priceProposals;

    public function __construct()
    {
        $this->priceProposals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAgent(): ?string
    {
        return $this->agent;
    }

    public function setAgent(string $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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
            $priceProposal->setProspect($this);
        }

        return $this;
    }

    public function removePriceProposal(PriceProposal $priceProposal): self
    {
        if ($this->priceProposals->removeElement($priceProposal)) {
            // set the owning side to null (unless already changed)
            if ($priceProposal->getProspect() === $this) {
                $priceProposal->setProspect(null);
            }
        }

        return $this;
    }
}
