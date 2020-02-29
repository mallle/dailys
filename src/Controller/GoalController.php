<?php

namespace App\Controller;

use App\Entity\Goal;
use App\Entity\User;
use App\Form\GoalType;
use App\Repository\GoalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoalController extends BaseController
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
     * @Route("/goals", name="app_goals")
     * @param GoalRepository $goalRepository
     * @return Response
     */
    public function index(GoalRepository $goalRepository)
    {
        $user = $this->getUser();
        $goals = $user->getGoals();

        return $this->render('goal/index.html.twig', [
            'navi' => 'goals',
            'goals' => $goals,
        ]);
    }


    /**
     * @Route("/goals/new", name="app_goals_new")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    function new (Request $request) {

        $goal = new Goal();

        $form = $this->createForm(GoalType::class, $goal);

        return $this->handleForm($goal, $form, $request);

    }

    /**
     * @Route("/goals/{goal}/edit", name="app_goals_edit")
     * @param Goal $goal
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Goal $goal, Request $request)
    {
        if($this->hasAccess($this->getUser(), $goal)){
            return $this->redirect($this->generateUrl('app_goals'));
        }

        $form = $this->createForm(GoalType::class, $goal);

        return $this->handleForm($goal, $form, $request);
    }

    /**
     * @Route("/goals/{goal}/delete", name="app_goals_delete")
     *
     * @param Goal $goal
     * @param Request $request
     *
     * @return Response
     */
    public function delete(Goal $goal, Request $request)
    {
        if($this->hasAccess($this->getUser(), $goal)){
            return $this->redirect($this->generateUrl('app_goals'));
        }

        $this->em->remove($goal);
        $this->em->flush();

        $goals = $this->getUser()->getGoals();

        return $this->render('goal/index.html.twig', [
            'navi' => 'goals',
            'goals' => $goals,
        ]);
    }

    /**
     * @param Goal $goal
     * @param FormInterface $formInterface
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    private function handleForm(Goal $goal, FormInterface $formInterface, Request $request)
    {
        // Handle form
        $formInterface->handleRequest($request);

        if ($formInterface->isSubmitted()) {
            if ($formInterface->isValid()) {

                $goal->setUser($this->getUser());

                $this->em->persist($goal);
                $this->em->flush();

                return $this->redirect($this->generateUrl('app_goals'));
            }
            //$this->addFlashMessage('error', '');
        }

        return $this->render('goal/edit.html.twig', [
            'navi' => 'goals',
            'form' => $formInterface->createView(),
            'goal' => $goal,
        ]);
    }

    /**
     * @Route("/goals/{goal}/done", name="app_goals_done")
     *
     * @param Goal $goal
     *
     * @return Response
     */
    public function done(Goal $goal)
    {
        if($this->hasAccess($this->getUser(), $goal)){
            return $this->redirect($this->generateUrl('app_goals'));
        }

        $goal->setDone(!$goal->getDone());
        $this->em->flush();

       return $this->redirect($this->generateUrl('app_goals'));
    }

    /**
     * @param User $user
     * @param Goal $goal
     * @return bool
     */
    private function hasAccess(User $user, Goal $goal): bool
    {
        if(!($goal->getUser()->getId() === $user->getId())){
            return true;
        }
        return false;
    }

}
