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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "#17a2b8"})
     */
    private $color = '#17a2b8';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="habits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Checked", mappedBy="habit")
     */
    private $checkeds;


    public function __construct()
    {
        $this->monthHabits = new ArrayCollection();
        $this->monthHabitToDays = new ArrayCollection();
        $this->monthToHabits = new ArrayCollection();
        $this->checkeds = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    /**
     * @return Collection|Checked[]
     */
    public function getCheckeds(): Collection
    {
        return $this->checkeds;
    }

    public function addChecked(Checked $checked): self
    {
        if (!$this->checkeds->contains($checked)) {
            $this->checkeds[] = $checked;
            $checked->setHabit($this);
        }

        return $this;
    }

    public function removeChecked(Checked $checked): self
    {
        if ($this->checkeds->contains($checked)) {
            $this->checkeds->removeElement($checked);
            // set the owning side to null (unless already changed)
            if ($checked->getHabit() === $this) {
                $checked->setHabit(null);
            }
        }

        return $this;
    }
}
