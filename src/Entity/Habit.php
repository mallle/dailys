<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
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
     * @ORM\Column(type="boolean", options={"default": true})
     * @var bool
     */
    private $showInTracker = true;

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


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }


    /**
     * @return bool|null
     */
    public function isShowInTracker(): ?bool
    {
        return $this->showInTracker;
    }

    /**
     * @param bool $showInTracker
     * @return $this
     */
    public function setShowInTracker(bool $showInTracker): self
    {
        $this->showInTracker = $showInTracker;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
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

    /**
     * @param Checked $checked
     * @return $this
     */
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

    /**
     * @param \DateTime|null $from
     * @param \DateTime|null $to
     *
     * @return Collection
     */
    public function getNumberOfWeeklyCheckedHabits(\DateTime $from = null,  \DateTime $to = null)
    {
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()->gte('checkedAt', $from));
        $criteria->andWhere(Criteria::expr()->lte('checkedAt', $to));

        return $this->getCheckeds()->matching($criteria);
    }
}
