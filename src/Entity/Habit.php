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
     * @ORM\OneToMany(targetEntity="App\Entity\MonthHabit", mappedBy="Habit")
     */
    private $monthHabits;

    public function __construct()
    {
        $this->monthHabits = new ArrayCollection();
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
     * @return Collection|MonthHabit[]
     */
    public function getMonthHabits(): Collection
    {
        return $this->monthHabits;
    }

    public function addMonthHabit(MonthHabit $monthHabit): self
    {
        if (!$this->monthHabits->contains($monthHabit)) {
            $this->monthHabits[] = $monthHabit;
            $monthHabit->setHabit($this);
        }

        return $this;
    }

    public function removeMonthHabit(MonthHabit $monthHabit): self
    {
        if ($this->monthHabits->contains($monthHabit)) {
            $this->monthHabits->removeElement($monthHabit);
            // set the owning side to null (unless already changed)
            if ($monthHabit->getHabit() === $this) {
                $monthHabit->setHabit(null);
            }
        }

        return $this;
    }
}
