<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Model\{User, Availability, Session};

class AvailabilityController
{
    public function getAvailabilityAction($params)
    {
        $availability = new Availability;
        $availability->id = $params['URL'][0];
        $availability->hydrate();

        Session::findBy('availabilities_id', $params['URL'][0]);

        echo json_decode(['status' => 'success', 'response' => $availability]);
    }
}
