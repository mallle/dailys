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
    private $Month;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Habit", inversedBy="monthToHabits")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $Habit;

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
}
