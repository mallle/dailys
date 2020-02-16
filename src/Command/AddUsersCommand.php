<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddUsersCommand extends Command
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

    protected static $defaultName = 'app:add-users';

    protected function configure()
    {
        $this
            ->setDescription('Add two users')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();
        $user->setEmail('d@darianina.com');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Shout776!set'
        ));
        $this->entityManager->persist($user);

        $user2 = new User();
        $user2->setEmail('maleneklit@hotmail.com');
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'Cross942-has'
        ));
        $this->entityManager->persist($user2);

        $this->entityManager->flush();

        $io->success('Added two new users to the database');

        return 0;
    }
}
