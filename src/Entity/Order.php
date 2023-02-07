<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['order:read'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['order:read'])]
    private $qty;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['order:read'])]
    private $date;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['order:read'])]
    private $_option;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read'])]
    private $product;

    #[ORM\Column(nullable: true)]
    #[Groups(['order:read'])]
    private ?string $status;


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

    public function getEagle(): ?User
    {
        return $this->eagle;
    }

    public function setEagle(?User $eagle): self
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }


}
