<?php

namespace App\Entity;

use App\Repository\DiscountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscountRepository::class)]
class Discount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'float')]
    private ?float $rate;

    #[ORM\OneToMany(mappedBy: 'discount', targetEntity: PriceProposal::class)]
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

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
            $priceProposal->setDiscount($this);
        }

        return $this;
    }

    public function removePriceProposal(PriceProposal $priceProposal): self
    {
        if ($this->priceProposals->removeElement($priceProposal)) {
            // set the owning side to null (unless already changed)
            if ($priceProposal->getDiscount() === $this) {
                $priceProposal->setDiscount(null);
            }
        }

        return $this;
    }
}
