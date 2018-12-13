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
        
        foreach ($user->availability as $availab) {
            $userMonth = date('m', strtotime($availab->start));
            $userDay = date('d', strtotime($availab->start));

            if ($userMonth === $month && isset($calendar[$userDay])) {
                $hour = date('H', strtotime($availab->start));
                $end = date('H', strtotime($availab->end));
                
                for ($i = $hour; $i <= $end; $i++)
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
