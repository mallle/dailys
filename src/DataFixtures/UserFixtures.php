<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {

        $user = new User();
        $user->setEmail('fs@de.de');
        $user->setPassword('1234');

        $manager->persist($user);
        $manager->flush();

    }
}
