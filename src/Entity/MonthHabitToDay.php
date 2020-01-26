<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthHabitToDayRepository")
 * @ORM\Table(name="month_to_habit_to_day")
 */
class MonthHabitToDay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="monthHabitToDays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Month", inversedBy="monthHabitToDays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $month;

    /**
     * @ORM\Column(type="boolean")
     */
    private $checked = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Habit", inversedBy="monthHabitToDays")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $habit;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(?Day $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMonth(): ?Month
    {
        return $this->month;
    }

    public function setMonth(?Month $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function getHabit(): ?Habit
    {
        return $this->habit;
    }

    public function setHabit(?Habit $habit): self
    {
        $this->habit = $habit;

        return $this;
    }

}
