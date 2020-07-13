<?php


namespace App\Services;


class DateHelper
{

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getWeekStartAndEnd() :array
    {
        $today = new \DateTime();
        $today->setTime(0,0,0,0);
        $monday = null;
        $sunday = null;
        if(date('D', $today->getTimestamp()) === 'Mon'){
            $monday = $today;
        } else {
            $monday = new \DateTime("previous monday" );
        }
        if(date('D', $today->getTimestamp()) === 'Sun'){
            $sunday = $today;
        } else {
            $sunday = new \DateTime("next sunday" );
        }

        return [
            'monday' => $monday,
            'sunday' => $sunday,
        ];
    }

}