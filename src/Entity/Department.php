<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Eagle::class)]
    private $eagles;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'departments')]
    private $posts;

    public function __construct()
    {
        $this->eagles = new ArrayCollection();
        $this->posts = new ArrayCollection();
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
     * @return Collection<int, Eagle>
     */
    public function getEagles(): Collection
    {
        return $this->eagles;
    }

    public function addEagle(Eagle $eagle): self
    {
        if (!$this->eagles->contains($eagle)) {
            $this->eagles[] = $eagle;
            $eagle->setDepartment($this);
        }

        return $this;
    }

    public function removeEagle(Eagle $eagle): self
    {
        if ($this->eagles->removeElement($eagle)) {
            // set the owning side to null (unless already changed)
            if ($eagle->getDepartment() === $this) {
                $eagle->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addDepartment($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeDepartment($this);
        }

        return $this;
    }
}
