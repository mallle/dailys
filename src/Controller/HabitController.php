<?php

namespace App\Controller;

use App\Entity\Habit;
use App\Entity\Month;
use App\Entity\MonthHabitToDay;
use App\Entity\MonthToHabit;
use App\Entity\User;
use App\Form\HabitType;
use App\Repository\DayRepository;
use App\Repository\HabitRepository;
use App\Repository\MonthRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class HabitController extends BaseController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var MonthRepository
     */
    private $monthRepository;

    /**
     * HabitController constructor.
     *
     * @param EntityManagerInterface $em
     * @param MonthRepository $monthRepository
     */
    public function __construct(EntityManagerInterface $em, MonthRepository $monthRepository)
    {
        $this->em = $em;
        $this->monthRepository = $monthRepository;
    }

    /**
     * @Route("/habits", name="app_habits")
     * @param HabitRepository $habitRepository
     * @return Response
     */
    public function index(HabitRepository $habitRepository)
    {
        $user = $this->getUser();
        $habits = $user->getHabits();

        return $this->render('habit/index.html.twig', [
            'navi' => 'habits',
            'habits' => $habits,
        ]);
    }


    /**
     * @Route("/habits/new", name="app_habits_new")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    function new (Request $request) {

        $habit = new Habit();

        $form = $this->createForm(HabitType::class, $habit);

        return $this->handleForm($habit, $form, $request);

    }

    /**
     * @Route("/habits/{habit}/edit", name="app_habits_edit")
     * @param Habit $habit
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Habit $habit, Request $request)
    {
        if($this->hasAccess($this->getUser(), $habit)){
            return $this->redirect($this->generateUrl('app_habits'));
        }

        $form = $this->createForm(HabitType::class, $habit);

        return $this->handleForm($habit, $form, $request);
    }

    /**
     * @Route("/habits/{habit}/delete", name="app_habits_delete")
     *
     * @param Habit $habit
     * @param Request $request
     * @param HabitRepository $habitRepository
     *
     * @return Response
     */
    public function delete(Habit $habit, Request $request, HabitRepository $habitRepository)
    {
        if($this->hasAccess($this->getUser(), $habit)){
            return $this->redirect($this->generateUrl('app_habits'));
        }

        $this->em->remove($habit);
        $this->em->flush();

        $habits = $this->getUser()->getHabits();

        return $this->render('habit/index.html.twig', [
            'navi' => 'habits',
            'habits' => $habits,
        ]);
    }

    /**
     * @param Habit $habit
     * @param FormInterface $formInterface
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    private function handleForm(Habit $habit, FormInterface $formInterface, Request $request)
    {
        // Handle form
        $formInterface->handleRequest($request);

        if ($formInterface->isSubmitted()) {
            if ($formInterface->isValid()) {

                $habit->setUser($this->getUser());

                $this->em->persist($habit);
                $this->em->flush();

                $months = $this->monthRepository->findAll();
                return $this->redirect($this->generateUrl('app_habits_edit', ['habit' => $habit->getId()]));
            }
            //$this->addFlashMessage('error', '');
        }

        return $this->render('habit/edit.html.twig', [
            'navi' => 'habits',
            'form' => $formInterface->createView(),
            'habit' => $habit,
        ]);
    }

    /**
     * @Route("/habits/{habit}/months", name="app_habits_months")
     *
     * @param Habit $habit
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function addMonthsToHabit(Habit $habit, Request $request, DayRepository $dayRepository)
    {

        $months = $this->monthRepository->findAll();

        $form = $this->createFormBuilder()
            ->add('months', ChoiceType::class, [
                'choices' => [
                    array_combine((Month::MONTHS), Month::MONTHS),
                ],
                'multiple' => TRUE,
                'expanded' => TRUE,
            ])
            ->add('confirm', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-outline-secondary'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $data = $form->getData();

                foreach ($data['months'] as $month){

                    $month = $this->monthRepository->findOneBy(['name' => $month]);

                    $monthToHabit = new MonthToHabit();
                    $monthToHabit->setHabit($habit);
                    $monthToHabit->setMonth($month);
                    $this->em->persist($monthToHabit);

                    $days = $dayRepository->findAll();
                    foreach($days as $day){
                        $monthHabitToDay = new MonthHabitToDay();
                        $monthHabitToDay->setMonth($month);
                        $monthHabitToDay->setHabit($habit);
                        $monthHabitToDay->setDay($day);
                        $this->em->persist($monthHabitToDay);
                    }

                }

                $this->em->flush();

                return $this->redirect($this->generateUrl('app_habits_edit', ['habit' => $habit->getId()]));
            }
            //$this->addFlashMessage('error', '');
        }

        return $this->render('habit/addMonths.html.twig', [
            'navi' => 'habits',
            'habit' => $habit,
            'months' => $months,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/habits/{monthToHabit}", name="app_habits_months_remove")
     *
     * @param MonthToHabit $monthToHabit
     * @param EntityManagerInterface $em
     *
     * @return RedirectResponse
     */
    public function removeMonthFromHabit(MonthToHabit $monthToHabit, EntityManagerInterface $em){

        $habit = $monthToHabit->getHabit();

        $em->remove($monthToHabit);
        $em->flush();

        return $this->redirect($this->generateUrl('app_habits_edit', ['habit' => $habit->getId()]));

    }

    /**
     * @param User $user
     * @param Habit $habit
     * @return bool
     */
    private function hasAccess(User $user, Habit $habit): bool
    {
        if(!($habit->getUser()->getId() === $user->getId())){
            return true;
        }
        return false;
    }

}
