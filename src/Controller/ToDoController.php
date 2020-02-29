<?php

namespace App\Controller;

use App\Entity\ToDo;
use App\Entity\User;
use App\Form\ToDoType;
use App\Repository\ToDoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends BaseController
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
     * @Route("/todos", name="app_todos")
     * @param ToDoRepository $todoRepository
     * @return Response
     */
    public function index(ToDoRepository $todoRepository)
    {
        $user = $this->getUser();
        $todos = $user->getToDos();

        return $this->render('todo/index.html.twig', [
            'navi' => 'todos',
            'todos' => $todos,
        ]);
    }


    /**
     * @Route("/todos/new", name="app_todos_new")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    function new (Request $request) {

        $todo = new ToDo();

        $form = $this->createForm(ToDoType::class, $todo);

        return $this->handleForm($todo, $form, $request);

    }

    /**
     * @Route("/todos/{todo}/edit", name="app_todos_edit")
     * @param ToDo $todo
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(ToDo $todo, Request $request)
    {
        if($this->hasAccess($this->getUser(), $todo)){
            return $this->redirect($this->generateUrl('app_todos'));
        }

        $form = $this->createForm(ToDoType::class, $todo);

        return $this->handleForm($todo, $form, $request);
    }

    /**
     * @Route("/todos/{todo}/delete", name="app_todos_delete")
     *
     * @param ToDo $todo
     * @param Request $request
     *
     * @return Response
     */
    public function delete(ToDo $todo, Request $request)
    {
        if($this->hasAccess($this->getUser(), $todo)){
            return $this->redirect($this->generateUrl('app_todos'));
        }

        $this->em->remove($todo);
        $this->em->flush();

        $todos = $this->getUser()->getToDos();

        return $this->render('todo/index.html.twig', [
            'navi' => 'todos',
            'todos' => $todos,
        ]);
    }

    /**
     * @param ToDo $todo
     * @param FormInterface $formInterface
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    private function handleForm(ToDo $todo, FormInterface $formInterface, Request $request)
    {
        // Handle form
        $formInterface->handleRequest($request);

        if ($formInterface->isSubmitted()) {
            if ($formInterface->isValid()) {

                $todo->setUser($this->getUser());

                $this->em->persist($todo);
                $this->em->flush();

                return $this->redirect($this->generateUrl('app_todos'));
            }
            //$this->addFlashMessage('error', '');
        }

        return $this->render('todo/edit.html.twig', [
            'navi' => 'todos',
            'form' => $formInterface->createView(),
            'todo' => $todo,
        ]);
    }

    /**
     * @Route("/todos/{todo}/done", name="app_todos_done")
     *
     * @param ToDo $todo
     *
     * @return Response
     */
    public function done(ToDo $todo)
    {
        if($this->hasAccess($this->getUser(), $todo)){
            return $this->redirect($this->generateUrl('app_todos'));
        }

        $todo->setDone(!$todo->getDone());
        $this->em->flush();

        return $this->redirect($this->generateUrl('app_todos'));
    }

    /**
     * @param User $user
     * @param ToDo $todo
     * @return bool
     */
    private function hasAccess(User $user, ToDo $todo): bool
    {
        if(!($todo->getUser()->getId() === $user->getId())){
            return true;
        }
        return false;
    }

}
