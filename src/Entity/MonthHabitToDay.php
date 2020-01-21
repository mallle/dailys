<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\MonthHabit", inversedBy="monthHabitToDays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monthHabit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Day", inversedBy="monthHabitToDays")
     * @ORM\JoinColumn(nullable=false)
     */
    private $day;

    /**
     * @ORM\Column(type="boolean")
     */
    private $checked = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonthHabit(): ?MonthHabit
    {
        return $this->monthHabit;
    }

    public function setMonthHabit(?MonthHabit $monthHabit): self
    {
        $this->monthHabit = $monthHabit;

        return $this;
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

    public function isChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }
}
