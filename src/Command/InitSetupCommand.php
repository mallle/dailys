<?php

namespace App\Command;

use App\Entity\Day;
use App\Entity\Month;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InitSetupCommand extends Command
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    protected static $defaultName = 'app:init-setup';

    protected function configure()
    {
        $this
            ->setDescription('Init setup')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        $io = new SymfonyStyle($input, $output);

        for($i = 1; $i <= 30; $i++){
            $day = new Day();
            $day->setNumber($i);
            $this->entityManager->persist($day);
        }

        foreach (Month::MONTHS as $month){
            $monthEntity = new Month();
            $monthEntity->setName($month);
            $this->entityManager->persist($monthEntity);
        }

        $this->entityManager->flush();

        $io->success('Init setup was successful');

        return 0;
    }
}
