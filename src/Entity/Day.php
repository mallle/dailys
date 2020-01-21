<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DayRepository")
 */
class Day
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonthHabitToDay", mappedBy="day")
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

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
            $monthHabitToDay->setDay($this);
        }

        return $this;
    }

    public function removeMonthHabitToDay(MonthHabitToDay $monthHabitToDay): self
    {
        if ($this->monthHabitToDays->contains($monthHabitToDay)) {
            $this->monthHabitToDays->removeElement($monthHabitToDay);
            // set the owning side to null (unless already changed)
            if ($monthHabitToDay->getDay() === $this) {
                $monthHabitToDay->setDay(null);
            }
        }

        return $this;
    }
}
