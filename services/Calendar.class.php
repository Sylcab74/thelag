<?php

namespace Lag\Service;

use \Lag\Model\User;
use \Lag\Model\Session;

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
        $monthDate = date('m', $date);
        $lastDay = (new \DateTime('1-'.$monthDate . '-2018'))->format('t');
        $numericDay = date('w', $date) == 0 ? 7 : date('w', $date);
        $weekStart = $day === null ? intval(date('d', strtotime('-'.($numericDay - 1).' days'))) : intval(date('d', $date));

        $objSession = new Session;
        $startSession = '2018-' . $monthDate  . '-' . $weekStart . ' 00:00:00';

        for ($u = 0; $u < 7; $u++){
            if ($weekStart > $lastDay){
                $weekStart = 1;
                $monthDate++;
            }

            $calendar[$weekStart.'-'.$monthDate] = [];
            for ($i = 0; $i < 24; $i++ )
                $calendar[$weekStart.'-'.$monthDate][$i] = false;

            $weekStart++;
        }

        foreach ($user->availability as $available) {
            $userMonth = date('m', strtotime($available->start));
            $userDay = date('d', strtotime($available->start));

            if ($userMonth === $monthDate && isset($calendar[$userDay.'-'.$monthDate])) {
                $hour = date('G', strtotime($available->start));
                $end = date('G', strtotime($available->end));
 
                for ($i = $hour; $i < $end; $i++)
                    $calendar[$userDay.'-'.$monthDate][$i] = $available->id;
            }
        }


        $endSession = '2018-' . $monthDate  . '-' . $weekStart . ' 00:00:00';
        $sessions = $objSession->getSessionBetweenTwoDate($startSession, $endSession);
        if (count($sessions) > 0) {
            foreach ($sessions as $session) {
                $sessionMonth = date('m', strtotime($session['start']));
                $sessionDay = date('d', strtotime($session['start']));

                if ($sessionMonth === $monthDate && isset($calendar[$sessionDay.'-'.$monthDate])) {
                    $hour = date('G', strtotime($session['start']));
                    $end = date('G', strtotime($session['end']));

                    for ($i = $hour; $i < $end; $i++)
                        $calendar[$sessionDay.'-'.$monthDate][$i] = "session";
                }
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
