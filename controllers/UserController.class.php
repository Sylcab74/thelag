<?php

namespace Lag\Controller;

use \Lag\Core\Views;
use \Lag\Model\User;

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

    public function registerAction($params)
    {
        $post = $params['POST'];

        if (count($post) > 0) {
            $response = [];

            $user = new User;
            $user->login = $post['identifiant'];
            $user->firstname = $post['firstname'];
            $user->lastname = $post['lastname'];
            $user->email = $post['email'];
            $user->biography = $post['biography'];
            $user->price = $post['price'];
            $user->save();

            $response['status'] = 'success';

            echo json_encode($response);
        }


        return Views::render("user.register", array());
    }
}
