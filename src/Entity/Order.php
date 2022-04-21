<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $qty;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $_option;

    #[ORM\ManyToOne(targetEntity: Eagle::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOption(): ?string
    {
        return $this->_option;
    }

    public function setOption(string $_option): self
    {
        $this->_option = $_option;

        return $this;
    }

    public function getEagle(): ?Eagle
    {
        return $this->eagle;
    }

    public function setEagle(?Eagle $eagle): self
    {
        $this->eagle = $eagle;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
