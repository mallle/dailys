<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Habit", mappedBy="user")
     */
    private $habits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="user")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $goals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ToDo", mappedBy="user")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $toDos;

    public function __construct()
    {
        $this->habits = new ArrayCollection();
        $this->goals = new ArrayCollection();
        $this->toDos = new ArrayCollection();
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
    public function getUsername(): string
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Habit[]
     */
    public function getHabits(): Collection
    {
        return $this->habits;
    }

    public function addHabit(Habit $habit): self
    {
        if (!$this->habits->contains($habit)) {
            $this->habits[] = $habit;
            $habit->setUser($this);
        }

        return $this;
    }

    public function removeHabit(Habit $habit): self
    {
        if ($this->habits->contains($habit)) {
            $this->habits->removeElement($habit);
            // set the owning side to null (unless already changed)
            if ($habit->getUser() === $this) {
                $habit->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals[] = $goal;
            $goal->setUser($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
            // set the owning side to null (unless already changed)
            if ($goal->getUser() === $this) {
                $goal->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ToDo[]
     */
    public function getToDos(): Collection
    {
        return $this->toDos;
    }

    public function addToDo(ToDo $toDo): self
    {
        if (!$this->toDos->contains($toDo)) {
            $this->toDos[] = $toDo;
            $toDo->setUser($this);
        }

        return $this;
    }

    public function removeToDo(ToDo $toDo): self
    {
        if ($this->toDos->contains($toDo)) {
            $this->toDos->removeElement($toDo);
            // set the owning side to null (unless already changed)
            if ($toDo->getUser() === $this) {
                $toDo->setUser(null);
            }
        }

        return $this;
    }
}
