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
        echo $blade->run("coach/coachs",array("users"=>$users));
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
        $month = date('m');
        $year = date('Y');
        
        $views = DIRNAME . '/views';
        $cache = DIRNAME . '/cache';
        $blade=new \eftec\bladeone\BladeOne("./views/", "./cache/", \eftec\bladeone\BladeOne::MODE_AUTO);
        echo $blade->run("coach/coach", array(
            "calendar" => $calendar,
            "user" => $user,
            "days" => $days,
            'year' => $year,
            "month" => $month,
            "start" => key($calendar)
        ));
    }

    public function changeWeekAction($params)
    {
        $data = [];

        $objCalendar = new Calendar();
        $month = $params['POST']['month'];
        $year = date('Y');
        $day = $params['POST']['action'] == 'next' ? $params['POST']['last'] + 1 : $params['POST']['first'] - 7;

        $user = new User;
        $user->id = $params['POST']['user'];
        $user->hydrate();

        $calendar = $objCalendar->createCalendar($user, $day, $month, $year);
 
        $data['status'] = 'success';
        $data['response']['calendar'] = $calendar;
        $data['response']['start'] = key($calendar);
        $data['response']['month'] = $month;
        
        echo json_encode($data);
    }

}
