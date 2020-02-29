<?php

namespace App\Twig;

use App\Repository\CheckedRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

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
}
