<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Model\{User, Availability, Session};

class AvailabilityController
{
    public function getAvailabilityAction($params)
    {
        $response = [];
        $availability = new Availability;
        $availability->id = $params['URL'][0];
        $availability->hydrate();

        //Session::findBy('availabilities_id', $params['URL'][0]);

        $duration = intval(date('h', strtotime($availabitity->start))) - intval(date('h', strtotime($availabitity->end)));
        var_dump($duration);
        $response['status'] = "success";
        //$response['duration']
        echo json_decode(['status' => 'success', 'response' => $availability]);
    }
}
