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
     * @ORM\OneToMany(targetEntity="App\Entity\MonthHabit", mappedBy="Month")
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
            $monthHabit->setMonth($this);
        }

        return $this;
    }

    public function removeMonthHabit(MonthHabit $monthHabit): self
    {
        if ($this->monthHabits->contains($monthHabit)) {
            $this->monthHabits->removeElement($monthHabit);
            // set the owning side to null (unless already changed)
            if ($monthHabit->getMonth() === $this) {
                $monthHabit->setMonth(null);
            }
        }

        return $this;
    }
}
