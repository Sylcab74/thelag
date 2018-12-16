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
    
    
    public function createCalendar(User $user, $day = null, $month = null, $year = null)
    {
        $calendar = [];
        $date = $day === null ? 'now' : $day . '-' . $month . '-' . $year;
        $date = strtotime($date);
        $numericDay = date('w', $date) == 0 ? 7 : date('w', $date);
        $month = date('m', $date);
        $weekStart = $day === null ? intval(date('d', strtotime('-'.($numericDay - 1).' days'))) : intval(date('d', $date));
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

    public function getDayAndMonth($first, $last, $month, $action)
    {
        $lastDay = (new \DateTime('1-'.$month . '-2018'))->format('t');

        if ($action == 'next') {
            $day = $last + 1;
            if ($day > $lastDay){
                $day = $day - $lastDay;
                $month++;
            }
        } else {
            $day = $first - 7;
            if ($day < 0) {
                $lastDay = (new \DateTime('1-'.$month -1 . '-2018'))->format('t');
                $day = $lastDay - $day;
                $month--;
            }
        }

        return [$month => $day];
    }

}
