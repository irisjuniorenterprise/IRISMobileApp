<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['list:read'])]
    private $name;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: User::class)]
    private $eagles;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'departments')]
    private $posts;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Service::class)]
    private $services;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Task::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->eagles = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->tasks = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getEagles(): Collection
    {
        return $this->eagles;
    }

    public function addEagle(User $eagle): self
    {
        if (!$this->eagles->contains($eagle)) {
            $this->eagles[] = $eagle;
            $eagle->setDepartment($this);
        }

        return $this;
    }

    public function removeEagle(User $eagle): self
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

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setDepartment($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getDepartment() === $this) {
                $service->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setDepartment($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getDepartment() === $this) {
                $task->setDepartment(null);
            }
        }

        return $this;
    }
}
