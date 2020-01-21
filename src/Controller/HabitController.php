<?php

namespace App\Controller;

use App\Repository\HabitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HabitController extends AbstractController
{
    /**
     * @Route("/habit", name="habit")
     */
    public function index(HabitRepository $habitRepository)
    {

        $habits = $habitRepository->findAll();

        return $this->render('habit/index.html.twig', [
            'habits' => $habits,
        ]);
    }
}
