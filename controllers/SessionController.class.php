<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Model\{User, Session};

class SessionController
{
    public function createAction($params)
    {
        $response = [];
        $post = $params['POST'];

        $session = new Session;
        $session->availabilities_id = $post['availability'];
        $session->participant_id = 3;
        $session->coach_id = $post['user'];
        $session->games_id = $post['game'];
        $session->comments = $post['comments'];

        $start = explode('/', $post['start']);
        $time = new \DateTime('2018-' . $start[0] . ' ' . $start[1] . ':00:00');
        $session->start = $time->format('Y-m-d H:i:s');
        $session->end = $time->modify('+' . $post['duration'] . 'hour')->format('Y-m-d H:i:s');

        $session->save();

        $response['status'] = 'success';
        $response['response'] = 'La session a bien été créée !';

        echo json_encode($response);
    }
}
