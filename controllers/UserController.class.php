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

    public function registerAction($params)
    {
        $post = $params['POST'];
        $errors = null;

        if (!empty( User::findBy('login', $post['login'])))
            $errors[] = "Désolé ce nom d'utilisateur est déjà utilisé.";

        if(!empty(User::findBy('email', $post['email'])))
            $errors[] = "Désolé cet email est déjà utilisé";

        if( strlen($post['password']) < 8)
            $errors[] = "Désolé, votre mot de passe doit contenir plus de 8 caractères";

        if(!is_null($errors))
            return Views::render('user.register', ["errors" => $errors]);


    }
}
