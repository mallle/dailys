<?php

namespace App\Controller;

use App\Entity\Checked;
use App\Entity\Habit;
use App\Repository\CheckedRepository;
use App\Repository\HabitRepository;
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
     * @Route("/tracker/{month}", name="app_tracker")
     *
     * @param string|null $month
     * @param HabitRepository $habitRepository
     * @param CheckedRepository $checkedRepo
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function tracker(string $month = null, HabitRepository $habitRepository, CheckedRepository $checkedRepo)
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
            'week' => $this->getWeekStartAndEnd(),
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
     * @return RedirectResponse
     * @throws \Exception
     */
    public function checkHabit(Habit $habit, string $date, EntityManagerInterface $em, CheckedRepository $checkedRepository) : RedirectResponse
    {
        $date = new \DateTime($date);
        $checkedHabit = $checkedRepository->findOneBy(['habit' => $habit->getId(), 'checkedAt' => $date]);

        if($checkedHabit) {
            $em->remove($checkedHabit);
            $em->flush();
            return $this->redirect($this->generateUrl('app_tracker'));
        }

        $checked = new Checked();

        $checked->setHabit($habit);
        $checked->setCheckedAt($date);
        $em->persist($checked);
        $em->flush();

        return $this->redirect($this->generateUrl('app_tracker', ['month' => $date->format('Y-m-01')]));
    }

    /**
     * @Route("/stats/{habit}", name="app_stats")
     *
     * @param Habit $habit
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function statistics(Habit $habit)
    {
        return $this->render('habit/stats.html.twig', [
            'navi' => 'tracker',
            'habit' => $habit,
            'week' => $this->getWeekStartAndEnd(),
        ]);
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getWeekStartAndEnd() :array
    {
        $today = new \DateTime();
        $monday = null;
        $sunday = null;

        if(date('D', $today->getTimestamp()) === 'Mon'){
            $monday = $today;
        } else {
            $monday = new \DateTime("previous monday" );
        }
        if(date('D', $today->getTimestamp()) === 'Sun'){
            $sunday = $today;
        } else {
            $sunday = new \DateTime("next sunday" );
        }

        return [
            'monday' => $monday,
            'sunday' => $sunday,
        ];
    }
}
