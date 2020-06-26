<?php

namespace App\Twig;

use App\Entity\Habit;
use App\Repository\CheckedRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var CheckedRepository
     */
    private $checkedRepository;

    /**
     * AppExtension constructor.
     * @param CheckedRepository $checkedRepository
     */
    public function __construct(CheckedRepository $checkedRepository)
    {
        $this->checkedRepository = $checkedRepository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('habit_is_checked', [$this, 'habitIsChecked']),
        ];
    }


    public function getFunctions(): array
    {
        return [
            new TwigFunction('habit_color', [$this, 'getHabitColor']),
        ];
    }

    /**
     * @param $value
     * @param int $habit
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function habitIsChecked($value, int $habit, string $date)
    {
        $date = new \DateTime($date);
        $checkedHabit = $this->checkedRepository->findOneBy(['habit' => $habit, 'checkedAt' => $date]);

        return $checkedHabit ? 'checked' : '';
    }

    /**
     * @param Habit $habit
     * @param string $date
     *
     * @return string
     * @throws \Exception
     */
    public function getHabitColor(Habit $habit, string $date)
    {
        $date = new \DateTime($date);
        $checkedHabit = $this->checkedRepository->findOneBy(['habit' => $habit, 'checkedAt' => $date]);

        return $checkedHabit !== null ? 'color: #f2f2f2' : 'color: ' . $habit->getColor();
    }
}
