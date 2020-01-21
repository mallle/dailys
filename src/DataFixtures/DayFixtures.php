<?php

namespace App\DataFixtures;

use App\Entity\Day;
use Doctrine\Common\Persistence\ObjectManager;

class DayFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {

        $this->createMany(Day::class, 31, function (Day $day, $count) {
            $day
                ->setNumber($count+1);
        });

        $manager->flush();

    }
}
