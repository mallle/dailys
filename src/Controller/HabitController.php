<?php

namespace App\Controller;

use App\Entity\Habit;
use App\Form\HabitType;
use App\Repository\HabitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class HabitController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * HabitController constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/habits", name="app_habits")
     * @param HabitRepository $habitRepository
     * @return Response
     */
    public function index(HabitRepository $habitRepository)
    {

        $habits = $habitRepository->findAll();

        return $this->render('habit/index.html.twig', [
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
        $this->em->remove($habit);
        $this->em->flush();

        $habits = $habitRepository->findAll();

        return $this->render('Habit/index.html.twig', [
            'habits' => $habits,
        ]);
    }

    private function handleForm(Habit $habit, FormInterface $formInterface, Request $request)
    {
        // Handle form
        $formInterface->handleRequest($request);

        if ($formInterface->isSubmitted()) {
            if ($formInterface->isValid()) {

                $this->em->persist($habit);
                $this->em->flush();

                return $this->redirect($this->generateUrl('app_habits_edit', ['habit' => $habit->getId()]));
            }
            //$this->addFlashMessage('error', '');
        }

        return $this->render('Habit/edit.html.twig', [
            'form' => $formInterface->createView(),
            'habit' => $habit,
        ]);
    }
}
