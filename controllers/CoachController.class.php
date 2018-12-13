<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Model\User;

class CoachController
{

    public function indexAction()
    {
        $users = User::findAll();

        $views = DIRNAME . '/views'; // it uses the folder /views to read the templates
        $cache = DIRNAME . '/cache'; // it uses the folder /cache to compile the result.
        $blade=new \eftec\bladeone\BladeOne("./views/", "./cache/", \eftec\bladeone\BladeOne::MODE_AUTO);
        echo $blade->run("coach",array("users"=>$users));
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
        
        $views = DIRNAME . '/views';
        $cache = DIRNAME . '/cache';
        $blade=new \eftec\bladeone\BladeOne("./views/", "./cache/", \eftec\bladeone\BladeOne::MODE_AUTO);
        echo $blade->run("calendar", array(
            "calendar" => $calendar,
            "user" => $user,
            "start" => key($calendar)
        ));
    }

}