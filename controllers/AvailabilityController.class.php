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

        $user = new User;
        $user->id = $availability->users_id;
        $user->games();

        $day = intval(date('d', strtotime($availability->start)));
        $month = intval(date('m', strtotime($availability->start)));

        $excludeSession = [];
        $sessions = Session::findBy('availabilities_id', $params['URL'][0]);

        if (count($sessions) > 0) {
            foreach ($sessions as $session) {
                $sessionStart = intval(date('H', strtotime($session->start)));
                $sessionEnd = intval(date('H', strtotime($session->end)));

                for ($sessionStart; $sessionStart < $sessionEnd; $sessionStart++)
                    $excludeSession[] = $month.'-'.$day.'/'.$sessionStart;
            }
        }

        $endHour = intval(date('H', strtotime($availability->end)));
        $startHour = intval(date('H', strtotime($availability->start)));

        for ($startHour; $startHour < $endHour; $startHour++)
            if (!in_array($month.'-'.$day.'/'.$startHour, $excludeSession))
                $startSession[] = [$month.'-'.$day.'/'.$startHour, $day . ' ' . self::MONTHS[$month-1] . ' ' . $startHour . 'h'];

        $response['status'] = "success";
        $response['session'] = $startSession;
        $response['games'] = $user->games;

        echo json_encode($response);
    }
}
