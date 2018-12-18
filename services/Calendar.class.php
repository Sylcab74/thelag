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
        $month = date('m', $date);
        $lastDay = (new \DateTime('1-'.$month . '-2018'))->format('t');
        $numericDay = date('w', $date) == 0 ? 7 : date('w', $date);
        $weekStart = $day === null ? intval(date('d', strtotime('-'.($numericDay - 1).' days'))) : intval(date('d', $date));

        for ($u = 0; $u < 7; $u++){
            if ($weekStart > $lastDay){
                $weekStart = 1;
                $month++;
            }

            $calendar[$weekStart.'-'.$month] = [];
            for ($i = 0; $i < 24; $i++ )
                $calendar[$weekStart.'-'.$month][$i] = false;

            $weekStart++;
        }
        
        foreach ($user->availability as $available) {
            $userMonth = date('m', strtotime($available->start));
            $userDay = date('d', strtotime($available->start));

            if ($userMonth === $month && isset($calendar[$userDay.'-'.$month])) {
                $hour = date('G', strtotime($available->start));
                $end = date('G', strtotime($available->end));
 
                for ($i = $hour; $i < $end; $i++)
                    $calendar[$userDay.'-'.$month][$i] = $available->id;
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
                $month = $month + 1 == 13 ? 1 : $month + 1;
            }
        } else {
            if ($first - 7 < 0) {
                $month = $month - 1 < 0 ? 12 : $month - 1;
                $lastDay = (new \DateTime('1-'. $month . '-2018'))->format('t');
                $day = $lastDay - (7 - $first);
            } else {
                $day = $first - 7;
            }
        }
        
        return [$month => $day];
    }

}
