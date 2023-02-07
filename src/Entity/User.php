<?php

namespace App\Entity;

use App\Repository\EagleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EagleRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: "Please enter your email")]
    #[Groups(['task:read', 'list:read'])]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['post:read', 'comments:read', 'list:read'])]
    private $fName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['post:read', 'comments:read', 'list:read'])]
    private $lName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['list:read'])]
    private $phone;

    #[ORM\Column(type: 'date')]
    private $birthday;

    #[ORM\Column(type: 'string', length: 255)]
    private $adress;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['post:read', 'comments:read', 'list:read'])]
    private $img;

    #[ORM\ManyToOne(targetEntity: University::class, inversedBy: 'eagles')]
    #[ORM\JoinColumn(nullable: false)]
    private $university;

    #[ORM\ManyToOne(targetEntity: StudyField::class, inversedBy: 'eagles')]
    #[ORM\JoinColumn(nullable: false)]
    private $studyField;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Request::class)]
    private $requests;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Order::class)]
    private $orders;

    #[ORM\ManyToOne(targetEntity: Department::class, inversedBy: 'eagles')]
    #[Groups(['list:read'])]
    private $department;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Post::class)]
    private $posts;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Comment::class)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Attendance::class)]
    private $attendances;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: AttendanceApproval::class)]
    private $attendanceApprovals;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: AttendanceDisapproval::class)]
    private $attendanceDisapprovals;

    #[ORM\OneToMany(mappedBy: 'sg', targetEntity: WorkPost::class)]
    private $workPosts;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Response::class)]
    private $responses;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Polling::class)]
    private $pollings;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Blame::class)]
    private $blames;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: History::class)]
    private $histories;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $linkedin;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Article::class)]
    private $articles;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tokenFcm = null;

    #[ORM\OneToMany(mappedBy: 'eagle', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'postedBy', targetEntity: BiblioIRIS::class)]
    private Collection $biblioIRIS;


    public function __construct()
    {
        $this->requests = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->attendances = new ArrayCollection();
        $this->attendanceApprovals = new ArrayCollection();
        $this->attendanceDisapprovals = new ArrayCollection();
        $this->workPosts = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->pollings = new ArrayCollection();
        $this->blames = new ArrayCollection();
        $this->histories = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->biblioIRIS = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFName(): ?string
    {
        return $this->fName;
    }

    public function setFName(string $fName): self
    {
        $this->fName = $fName;

        return $this;
    }

    public function getLName(): ?string
    {
        return $this->lName;
    }

    public function setLName(string $lName): self
    {
        $this->lName = $lName;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }
    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->university;
    }

    public function setUniversity(?University $university): self
    {
        $this->university = $university;

        return $this;
    }

    public function getStudyField(): ?StudyField
    {
        return $this->studyField;
    }

    public function setStudyField(?StudyField $studyField): self
    {
        $this->studyField = $studyField;

        return $this;
    }

    /**
     * @return Collection<int, Request>
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setEagle($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getEagle() === $this) {
                $request->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setEagle($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getEagle() === $this) {
                $order->setEagle(null);
            }
        }

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

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
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

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
            $comment->setEagle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEagle() === $this) {
                $comment->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Attendance>
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setEagle($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->removeElement($attendance)) {
            // set the owning side to null (unless already changed)
            if ($attendance->getEagle() === $this) {
                $attendance->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttendanceApproval>
     */
    public function getAttendanceApprovals(): Collection
    {
        return $this->attendanceApprovals;
    }

    public function addAttendanceApproval(AttendanceApproval $attendanceApproval): self
    {
        if (!$this->attendanceApprovals->contains($attendanceApproval)) {
            $this->attendanceApprovals[] = $attendanceApproval;
            $attendanceApproval->setEagle($this);
        }

        return $this;
    }

    public function removeAttendanceApproval(AttendanceApproval $attendanceApproval): self
    {
        if ($this->attendanceApprovals->removeElement($attendanceApproval)) {
            // set the owning side to null (unless already changed)
            if ($attendanceApproval->getEagle() === $this) {
                $attendanceApproval->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttendanceDisapproval>
     */
    public function getAttendanceDisapprovals(): Collection
    {
        return $this->attendanceDisapprovals;
    }

    public function addAttendanceDisapproval(AttendanceDisapproval $attendanceDisapproval): self
    {
        if (!$this->attendanceDisapprovals->contains($attendanceDisapproval)) {
            $this->attendanceDisapprovals[] = $attendanceDisapproval;
            $attendanceDisapproval->setEagle($this);
        }

        return $this;
    }

    public function removeAttendanceDisapproval(AttendanceDisapproval $attendanceDisapproval): self
    {
        if ($this->attendanceDisapprovals->removeElement($attendanceDisapproval)) {
            // set the owning side to null (unless already changed)
            if ($attendanceDisapproval->getEagle() === $this) {
                $attendanceDisapproval->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorkPost>
     */
    public function getWorkPosts(): Collection
    {
        return $this->workPosts;
    }

    public function addWorkPost(WorkPost $workPost): self
    {
        if (!$this->workPosts->contains($workPost)) {
            $this->workPosts[] = $workPost;
            $workPost->setSg($this);
        }

        return $this;
    }

    public function removeWorkPost(WorkPost $workPost): self
    {
        if ($this->workPosts->removeElement($workPost)) {
            // set the owning side to null (unless already changed)
            if ($workPost->getSg() === $this) {
                $workPost->setSg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setEagle($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getEagle() === $this) {
                $response->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Polling>
     */
    public function getPollings(): Collection
    {
        return $this->pollings;
    }

    public function addPolling(Polling $polling): self
    {
        if (!$this->pollings->contains($polling)) {
            $this->pollings[] = $polling;
            $polling->setEagle($this);
        }

        return $this;
    }

    public function removePolling(Polling $polling): self
    {
        if ($this->pollings->removeElement($polling)) {
            // set the owning side to null (unless already changed)
            if ($polling->getEagle() === $this) {
                $polling->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Blame>
     */
    public function getBlames(): Collection
    {
        return $this->blames;
    }

    public function addBlame(Blame $blame): self
    {
        if (!$this->blames->contains($blame)) {
            $this->blames[] = $blame;
            $blame->setEagle($this);
        }

        return $this;
    }

    public function removeBlame(Blame $blame): self
    {
        if ($this->blames->removeElement($blame)) {
            // set the owning side to null (unless already changed)
            if ($blame->getEagle() === $this) {
                $blame->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, History>
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): self
    {
        if (!$this->histories->contains($history)) {
            $this->histories[] = $history;
            $history->setEagle($this);
        }

        return $this;
    }

    public function removeHistory(History $history): self
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getEagle() === $this) {
                $history->setEagle(null);
            }
        }

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setEagle($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getEagle() === $this) {
                $article->setEagle(null);
            }
        }

        return $this;
    }

    public function getTokenFcm(): ?string
    {
        return $this->tokenFcm;
    }

    public function setTokenFcm(?string $tokenFcm): self
    {
        $this->tokenFcm = $tokenFcm;

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
            $task->setEagle($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getEagle() === $this) {
                $task->setEagle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BiblioIRIS>
     */
    public function getBiblioIRIS(): Collection
    {
        return $this->biblioIRIS;
    }

    public function addBiblioIRI(BiblioIRIS $biblioIRI): self
    {
        if (!$this->biblioIRIS->contains($biblioIRI)) {
            $this->biblioIRIS->add($biblioIRI);
            $biblioIRI->setPostedBy($this);
        }

        return $this;
    }

    public function removeBiblioIRI(BiblioIRIS $biblioIRI): self
    {
        if ($this->biblioIRIS->removeElement($biblioIRI)) {
            // set the owning side to null (unless already changed)
            if ($biblioIRI->getPostedBy() === $this) {
                $biblioIRI->setPostedBy(null);
            }
        }

        return $this;
    }
}
