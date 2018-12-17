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
        $user->games();

        $objCalendar = new Calendar;
        $calendar = $objCalendar->createCalendar($user);
        $days = $objCalendar->days;

        $start = key($calendar);

        return Views::render("coach.coach", array(
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
    
    public function handleGameAction($params)
    {
        $data = [];

        $post = $params['POST'];
        $user = new User;
        $user->id = 2;

        if ($post['action'] === "add") {
            $user->addGame($post['game']);
            $data['response'] = 'Le jeu a bien été ajouté à votre bibliothéque !';
        } else {
            $user->removeGame($post['game']);
            $data['response'] = 'Le jeu a bien été supprimé de votre bibliothéque !';
        }
        
        $data['status'] = 'success';
       
        echo json_encode($data);
    }
}
