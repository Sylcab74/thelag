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

        $views = DIRNAME . '/views';
        $cache = DIRNAME . '/cache';
        $blade=new \eftec\bladeone\BladeOne("./views/", "./cache/", \eftec\bladeone\BladeOne::MODE_AUTO);
        echo $blade->run("coach/coach", array(
            "calendar" => $calendar,
            "user" => $user,
            "days" => $days,
            'year' => date('Y'),
            "month" => date('m'),
            "start" => key($calendar)
        ));
    }

    public function changeWeekAction($params)
    {
        $data = [];
        
        $post = $params['POST'];
        $year = date('Y');
        $objCalendar = new Calendar();

        $user = new User;
        $user->id = $post['user'];
        $user->hydrate();

        $dayMonth = $objCalendar->getDayAndMonth($post['first'], $post['last'], $post['month'], $post['action']);
        $calendar = $objCalendar->createCalendar($user, current($dayMonth), key($dayMonth), $year);
 
        $data['status'] = 'success';
        $data['response']['calendar'] = $calendar;
        $data['response']['start'] = key($calendar);
        $data['response']['month'] = key($dayMonth);
        
        echo json_encode($data);
    }

}
