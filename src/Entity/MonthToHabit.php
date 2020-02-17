<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonthToHabitRepository")
 */
class MonthToHabit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Month", inversedBy="monthToHabits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $month;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Habit", inversedBy="monthToHabits")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $habit;

    public function getId(): ?int
    {
        return $this->id;
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
