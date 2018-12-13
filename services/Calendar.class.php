<?php

namespace Lag\Service;

use \Lag\Model\User;

class Calendar
{
    /**
     * Days of the week
     * @var Array
     */
    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    
    
    public function createCalendar(User $user)
    {
        $calendar = [];
        $day = date('w');
        $month = date('m');
        $weekStart = intval(date('d', strtotime('-'.($day - 1).' days')));
        $limit = $weekStart + 7;

        for ($weekStart; $weekStart < $limit; $weekStart++){
            $calendar[$weekStart] = [];
            for ($i = 0; $i < 23; $i++ )
                $calendar[$weekStart][$i] = false; 
        }
        
        foreach ($user->availability as $available) {
            $userMonth = date('m', strtotime($available->start));
            $userDay = date('d', strtotime($available->start));

            if ($userMonth === $month && isset($calendar[$userDay])) {
                $hour = date('G', strtotime($available->start));
                $end = date('G', strtotime($available->end));
 
                for ($i = $hour; $i < $end; $i++)
                    $calendar[$userDay][$i] = true;
            }
        }

        return $calendar;
    }
    
    public function changeWeek()
    {
        //
    }
}
