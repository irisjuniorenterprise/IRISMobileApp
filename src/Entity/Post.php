<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $publishDate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $targets;

    #[ORM\ManyToOne(targetEntity: Eagle::class, inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private $author;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private $comments;

    #[ORM\OneToOne(mappedBy: 'post', targetEntity: EngagementPost::class, cascade: ['persist', 'remove'])]
    private $engagementPost;

    #[ORM\OneToOne(mappedBy: 'post', targetEntity: Announcement::class, cascade: ['persist', 'remove'])]
    private $announcement;

    #[ORM\ManyToMany(targetEntity: Department::class, inversedBy: 'posts')]
    private $departments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->departments = new ArrayCollection();
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

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getTargets(): ?string
    {
        return $this->targets;
    }

    public function setTargets(?string $targets): self
    {
        $this->targets = $targets;

        return $this;
    }

    public function getAuthor(): ?Eagle
    {
        return $this->author;
    }

    public function setAuthor(?Eagle $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getEngagementPost(): ?EngagementPost
    {
        return $this->engagementPost;
    }

    public function setEngagementPost(EngagementPost $engagementPost): self
    {
        // set the owning side of the relation if necessary
        if ($engagementPost->getPost() !== $this) {
            $engagementPost->setPost($this);
        }

        $this->engagementPost = $engagementPost;

        return $this;
    }

    public function getAnnouncement(): ?Announcement
    {
        return $this->announcement;
    }

    public function setAnnouncement(Announcement $announcement): self
    {
        // set the owning side of the relation if necessary
        if ($announcement->getPost() !== $this) {
            $announcement->setPost($this);
        }

        $this->announcement = $announcement;

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->departments->contains($department)) {
            $this->departments[] = $department;
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        $this->departments->removeElement($department);

        return $this;
    }


}
