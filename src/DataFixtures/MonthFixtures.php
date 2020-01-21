<?php

namespace App\DataFixtures;

use App\Entity\Month;
use Doctrine\Common\Persistence\ObjectManager;

class MonthFixtures extends BaseFixture
{

    private $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    public function loadData(ObjectManager $manager)
    {

        foreach ($this->months as $month){
            $monthEntity = new Month();
            $monthEntity->setName($month);
            $manager->persist($monthEntity);
        }

        $manager->flush();

    }
}
