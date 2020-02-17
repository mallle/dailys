<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HabitRepository")
 */
class Habit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonthHabitToDay", mappedBy="habit")
     */
    private $monthHabitToDays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonthToHabit", mappedBy="habit")
     */
    private $monthToHabits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="habits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->monthHabits = new ArrayCollection();
        $this->monthHabitToDays = new ArrayCollection();
        $this->monthToHabits = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }


    /**
     * @return Collection|MonthHabitToDay[]
     */
    public function getMonthHabitToDays(): Collection
    {
        return $this->monthHabitToDays;
    }

    public function addMonthHabitToDay(MonthHabitToDay $monthHabitToDay): self
    {
        if (!$this->monthHabitToDays->contains($monthHabitToDay)) {
            $this->monthHabitToDays[] = $monthHabitToDay;
            $monthHabitToDay->setHabit($this);
        }

        return $this;
    }

    public function removeMonthHabitToDay(MonthHabitToDay $monthHabitToDay): self
    {
        if ($this->monthHabitToDays->contains($monthHabitToDay)) {
            $this->monthHabitToDays->removeElement($monthHabitToDay);
            // set the owning side to null (unless already changed)
            if ($monthHabitToDay->getHabit() === $this) {
                $monthHabitToDay->setHabit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MonthToHabit[]
     */
    public function getMonthToHabits(): Collection
    {
        return $this->monthToHabits;
    }

    public function addMonthToHabit(MonthToHabit $monthToHabit): self
    {
        if (!$this->monthToHabits->contains($monthToHabit)) {
            $this->monthToHabits[] = $monthToHabit;
            $monthToHabit->setHabit($this);
        }

        return $this;
    }

    public function removeMonthToHabit(MonthToHabit $monthToHabit): self
    {
        if ($this->monthToHabits->contains($monthToHabit)) {
            $this->monthToHabits->removeElement($monthToHabit);
            // set the owning side to null (unless already changed)
            if ($monthToHabit->getHabit() === $this) {
                $monthToHabit->setHabit(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
