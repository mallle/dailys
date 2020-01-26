<?php

namespace App\Twig;

use App\Entity\Day;
use App\Entity\Habit;
use App\Entity\Month;
use App\Entity\MonthToHabit;
use App\Repository\MonthHabitToDayRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    /**
     * @var MonthHabitToDayRepository
     */
    private $monthHabitToDayRepository;

    /**
     * AppExtension constructor.
     * @param MonthHabitToDayRepository $monthHabitToDayRepository
     */
    public function __construct(MonthHabitToDayRepository $monthHabitToDayRepository)
    {
        $this->monthHabitToDayRepository = $monthHabitToDayRepository;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('habit_is_checked', [$this, 'habitIsChecked']),
        ];
    }


    /**
     * @param $value
     * @param int $habit
     * @param int $month
     * @param int $day
     *
     * @return string
     */
    public function habitIsChecked($value, int $habit, int $month, int $day)
    {
        $monthHabitToDay = $this->monthHabitToDayRepository->findOneBy([
            'habit' => $habit,
            'month' => $month,
            'day' => $day
        ]);

        return $monthHabitToDay->isChecked() ? 'checked' : '';
    }
}
