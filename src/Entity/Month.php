<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthRepository")
 */
class Month
{

    const MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonthHabitToDay", mappedBy="month")
     */
    private $monthHabitToDays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonthToHabit", mappedBy="Month")
     */
    private $monthToHabits;

    public function __construct()
    {
        $this->monthHabitToDays = new ArrayCollection();
        $this->monthToHabits = new ArrayCollection();
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
            $monthHabitToDay->setMonth($this);
        }

        return $this;
    }

    public function removeMonthHabitToDay(MonthHabitToDay $monthHabitToDay): self
    {
        if ($this->monthHabitToDays->contains($monthHabitToDay)) {
            $this->monthHabitToDays->removeElement($monthHabitToDay);
            // set the owning side to null (unless already changed)
            if ($monthHabitToDay->getMonth() === $this) {
                $monthHabitToDay->setMonth(null);
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
            $monthToHabit->setMonth($this);
        }

        return $this;
    }

    public function removeMonthToHabit(MonthToHabit $monthToHabit): self
    {
        if ($this->monthToHabits->contains($monthToHabit)) {
            $this->monthToHabits->removeElement($monthToHabit);
            // set the owning side to null (unless already changed)
            if ($monthToHabit->getMonth() === $this) {
                $monthToHabit->setMonth(null);
            }
        }

        return $this;
    }
}
