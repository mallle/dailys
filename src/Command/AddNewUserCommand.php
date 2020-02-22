<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddNewUserCommand extends Command
{

    protected static $defaultName = 'app:add-new-user';

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

    protected function configure()
    {
        $this
            ->setDescription('Add a new user to the system')
            ->addArgument('emailAddress', InputArgument::REQUIRED, 'Please enter a email-address')
            ->addArgument('password', InputArgument::REQUIRED, 'Please enter a password')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $emailAddress = $input->getArgument('emailAddress');
        $password = $input->getArgument('password');

        if ($emailAddress && $password) {

            $user = new User();
            $user->setEmail($emailAddress);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $password
            ));
            $this->entityManager->persist($user);

            $this->entityManager->flush();

            $io->success(sprintf('Added a new user with email: %s to the database', $emailAddress));

            return 0;
        }

        $io->error('Something went wrong please try again');

        return 1;
    }
}
