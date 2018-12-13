<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Model\User;
use \Lag\Core\Views;

class CoachController
{

    public function indexAction()
    {
        $users = User::findAll();

        return Views::render("coach.coachs", array("users" => $users));
    }

    public function showAction($params)
    {
        $user = new User;
        $user->id = $params['URL'][0];
        $user->hydrate();

        $objCalendar = new Calendar;
        $calendar = $objCalendar->createCalendar($user);
        $days = $objCalendar->days;
        $start = key($calendar);

        return Views::render("coach.coach", array(
            "calendar" => $calendar,
            "user" => $user,
            "days" => $days,
            "start" => key($calendar)
        ));
    }

}
