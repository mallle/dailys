<?php

namespace App\Command;

use App\Entity\Checked;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TransferDataCommand extends Command
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserFixtures constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }
    protected static $defaultName = 'app:transfer-data';

    protected function configure()
    {
        $this
            ->setDescription('Transfer old data to new data structure')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user1 = $this->userRepository->find('2');
        $user2 = $this->userRepository->find('12');

        foreach ($user1->getHabits() as $habit){
            if($habit->getId() === 32){
                for($i = 1; $i <= 29; $i++ ){
                    $date = new \DateTime( $i . ' February 2020');

                    $checked = new Checked();
                    $checked->setHabit($habit);
                    $checked->setCheckedAt($date);
                    $this->entityManager->persist($checked);
                }
            }
        }
        $this->entityManager->flush();

        foreach ($user2->getHabits() as $habit){
            if($habit->getId() === 52 || $habit->getId() === 62){
                for($i = 1; $i <= 29; $i++ ){
                    $date = new \DateTime( $i . ' February 2020');
                    $checked = new Checked();
                    $checked->setHabit($habit);
                    $checked->setCheckedAt($date);
                    $this->entityManager->persist($checked);
                }
            }
        }
        $this->entityManager->flush();
        
        $io->success('The data where transferred');

        return 0;
    }
}
