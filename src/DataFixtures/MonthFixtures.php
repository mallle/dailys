<?php

namespace App\DataFixtures;

use App\Entity\Month;
use Doctrine\Common\Persistence\ObjectManager;

class MonthFixtures extends BaseFixture
{

    public function loadData(ObjectManager $manager)
    {

        foreach (Month::MONTHS as $month){
            $monthEntity = new Month();
            $monthEntity->setName($month);
            $manager->persist($monthEntity);
        }

        $manager->flush();

    }
}
