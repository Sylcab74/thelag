<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Model\{User, Availability, Session};

class AvailabilityController
{
    CONST MONTHS = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'décembre'];
    
    public function getAvailabilityAction($params)
    {
        $response = [];
        $startSession = [];

        $availability = new Availability;
        $availability->id = $params['URL'][0];
        $availability->hydrate();

        $endHour = intval(date('H', strtotime($availability->end)));
        $startHour = intval(date('H', strtotime($availability->start)));
        $day = intval(date('d', strtotime($availability->start)));
        $month = intval(date('m', strtotime($availability->start)));

        $duration = $endHour - $startHour;

        for ($startHour; $startHour < $endHour; $startHour++){
            $startSession[] = $day . ' ' . self::MONTHS[$month-1] . ' ' . $startHour . 'h';
        }

        //Session::findBy('availabilities_id', $params['URL'][0]);
        $response['status'] = "success";
        $response['duration'] = $duration;
        $response['session'] = $startSession;

        echo json_encode($response);
    }
}
