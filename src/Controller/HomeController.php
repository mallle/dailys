<?php

namespace App\Controller;

use App\Entity\Checked;
use App\Entity\Habit;
use App\Repository\CheckedRepository;
use App\Repository\HabitRepository;
use App\Services\DateHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/tracker/{month}", name="app_tracker")
     *
     * @param string|null $month
     * @param HabitRepository $habitRepository
     * @param DateHelper $dateHelper
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function tracker(HabitRepository $habitRepository, DateHelper $dateHelper, string $month = null)
    {
        $habits = $habitRepository->findBy(['user' => $this->getUser(), 'showInTracker' => true]);

        if(!$month){
            $time = new \DateTime();
        }else{
            $time = new \DateTime($month);
        }

        $nextMonth = date('Y-m-d', strtotime('+1 month', $time->getTimestamp()));
        $lastMonth = date('Y-m-d', strtotime('-1 month', $time->getTimestamp()));

        return $this->render('tracker.html.twig', [
            'navi' => 'tracker',
            'habits' => $habits,
            'time' => $time,
            'nextMonth' => $nextMonth,
            'lastMonth' => $lastMonth,
            'week' => $dateHelper->getWeekStartAndEnd(),
        ]);
    }

    /**
     * @Route("/check/{habit}/{date}", name="app_habit_check")
     *
     * @param Habit $habit
     * @param string $date
     * @param EntityManagerInterface $em
     * @param CheckedRepository $checkedRepository
     * 
     * @return JsonResponse
     * @throws \Exception
     */
    public function checkHabit(Habit $habit, string $date, DateHelper $dateHelper, EntityManagerInterface $em, CheckedRepository $checkedRepository) : JsonResponse
    {
        $date = new \DateTime($date);
        $checkedHabit = $checkedRepository->findOneBy(['habit' => $habit->getId(), 'checkedAt' => $date]);
        $week = $dateHelper->getWeekStartAndEnd();

        if($checkedHabit) {
            $em->remove($checkedHabit);
            $em->flush();

            return new JsonResponse([
                'id' => $habit->getId(),
                'checked' =>'false',
                'bgColor' => Habit::BG_COLOR,
                'color' => $habit->getColor(),
                'count' => $habit->getNumberOfWeeklyCheckedHabits($week['monday'], $week['sunday'])->count()
            ]);
        }

        $checked = new Checked();

        $checked->setHabit($habit);
        $checked->setCheckedAt($date);
        $em->persist($checked);
        $em->flush();

        return new JsonResponse([
            'id' => $habit->getId(),
            'checked' => 'true',
            'bgColor' => $habit->getColor(),
            'color' => Habit::COLOR_WHITE,
            'count' => $habit->getNumberOfWeeklyCheckedHabits($week['monday'], $week['sunday'])->count()
        ]);
    }
}
