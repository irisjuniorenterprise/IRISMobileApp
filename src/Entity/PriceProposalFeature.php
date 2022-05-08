<?php

namespace App\Entity;

use App\Repository\PriceProposalFeatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceProposalFeatureRepository::class)]
class PriceProposalFeature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private  $description;

    #[ORM\Column(type: 'integer')]
    private ?int $qty;

    #[ORM\Column(type: 'float')]
    private ?float $price;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $discount;

    #[ORM\ManyToOne(targetEntity: PriceProposal::class, inversedBy: 'priceProposalFeature')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PriceProposal $priceProposal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getPriceProposal(): ?PriceProposal
    {
        return $this->priceProposal;
    }

    public function setPriceProposal(?PriceProposal $priceProposal): self
    {
        $this->priceProposal = $priceProposal;

        return $this;
    }
}
