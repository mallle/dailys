<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\Habit;
use App\Entity\Month;
use App\Repository\DayRepository;
use App\Repository\MonthHabitRepository;
use App\Repository\MonthHabitToDayRepository;
use App\Repository\MonthRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{

    /**
     * @Route("/", name="app_home")
     *
     * @return Response
     */
    public function index()
    {

        return $this->render('index.html.twig', [
            'navi' => 'home',
        ]);
    }


    /**
     * @Route("/tracker", name="app_tracker")
     * @param MonthRepository $monthRepository
     * @param DayRepository $dayRepository
     *
     * @return Response
     */
    public function tracker(MonthRepository $monthRepository, DayRepository $dayRepository)
    {
        $habits = $this->getUser()->getHabits();

        $months = $monthRepository->findMonthForUser($this->getUser());

        $days = $dayRepository->findAll();

        return $this->render('tracker.html.twig', [
            'navi' => 'tracker',
            'months' => $months,
            'days' => $days,
            'habits' => $habits,
        ]);
    }


    /**
     * @Route("/check/{habit}/{month}/{day}", name="app_months_habits_check")
     *
     * @param Habit $habit
     * @param Day $day
     *
     * @param Month $month
     * @param MonthHabitToDayRepository $monthHabitToDayRepository
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function check(Habit $habit, Day $day, Month $month, MonthHabitToDayRepository $monthHabitToDayRepository, EntityManagerInterface $em)
    {

        $monthHabitToDay = $monthHabitToDayRepository->findOneBy(['habit' => $habit, 'month' => $month, 'day' => $day]);

        $monthHabitToDay->setChecked(!$monthHabitToDay->isChecked());

        $em->flush();

        return $this->redirect($this->generateUrl('app_tracker'));
    }
}
