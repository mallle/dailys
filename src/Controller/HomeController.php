<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\Habit;
use App\Entity\Month;
use App\Entity\MonthHabitToDay;
use App\Repository\DayRepository;
use App\Repository\MonthHabitRepository;
use App\Repository\MonthHabitToDayRepository;
use App\Repository\MonthRepository;
use App\Repository\MonthToHabitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="app_habits_home")
     */
    public function index(MonthToHabitRepository $monthHabitRepository, MonthRepository $monthRepository, DayRepository $dayRepository)
    {

        $monthsHabits = $monthHabitRepository->findAll();

        $months = $monthRepository->findAll();

        $days = $dayRepository->findAll();



        return $this->render('index.html.twig', [
            'navi' => 'home',
            'months' => $months,
            'days' => $days,
            'monthsHabits' => $monthsHabits,
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function check(Habit $habit, Day $day, Month $month, MonthHabitToDayRepository $monthHabitToDayRepository, EntityManagerInterface $em)
    {

        $monthHabitToDay = $monthHabitToDayRepository->findOneBy(['habit' => $habit, 'month' => $month, 'day' => $day]);

        $monthHabitToDay->setChecked(!$monthHabitToDay->isChecked());

//        $em->persist($monthHabitToDay);
        $em->flush();

        return $this->redirect($this->generateUrl('app_habits_home'));
    }
}
