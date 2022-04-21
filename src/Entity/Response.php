<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $response;

    #[ORM\ManyToOne(targetEntity: Field::class, inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: false)]
    private $field;

    #[ORM\ManyToOne(targetEntity: Eagle::class, inversedBy: 'responses')]
    #[ORM\JoinColumn(nullable: false)]
    private $eagle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): self
    {
        $this->field = $field;

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
}
