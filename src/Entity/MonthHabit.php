<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthHabitRepository")
 * @ORM\Table(name="month_to_habit")
 */
class MonthHabit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Month", inversedBy="monthHabits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Month;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Habit", inversedBy="monthHabits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Habit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonthHabitToDay", mappedBy="monthHabit")
     */
    private $monthHabitToDays;

    public function __construct()
    {
        $this->monthHabitToDays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonth(): ?Month
    {
        return $this->Month;
    }

    public function setMonth(?Month $Month): self
    {
        $this->Month = $Month;

        return $this;
    }

    public function getHabit(): ?Habit
    {
        return $this->Habit;
    }

    public function setHabit(?Habit $Habit): self
    {
        $this->Habit = $Habit;

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
            $monthHabitToDay->setMonthHabit($this);
        }

        return $this;
    }

    public function removeMonthHabitToDay(MonthHabitToDay $monthHabitToDay): self
    {
        if ($this->monthHabitToDays->contains($monthHabitToDay)) {
            $this->monthHabitToDays->removeElement($monthHabitToDay);
            // set the owning side to null (unless already changed)
            if ($monthHabitToDay->getMonthHabit() === $this) {
                $monthHabitToDay->setMonthHabit(null);
            }
        }

        return $this;
    }


}
