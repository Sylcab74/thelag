<?php

namespace Lag\Controller;

use \Lag\Model\User;
use \Lag\Core\Views;

class UserController
{
    public function addGameAction($params)
    {
        $data = [];

        $post = $params['POST'];
        $gameId = $post['game'];
        $userId = $post['user'];


        $data['status'] = 'success';
        $data['response'] = 'Le jeu a bien était ajouté à votre bibliothéque !';
    }
}
