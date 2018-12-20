<?php

namespace Lag\Controller;

use Lag\Core\Auth;
use \Lag\Core\Views;
use \Lag\Model\{User, Game};

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

            $errors = [];

            if (count( User::findBy('login', $post['login'])) > 0)
                $errors[] = "Désolé ce nom d'utilisateur est déjà utilisé.";


            if(!empty(User::findBy('email', $post['email'])))
                $errors[] = "Désolé cet email est déjà utilisé";

            if( $post['password'] !== $post['password_verify'])
                $errors[] = "Les mots de passe ne correspondent pas";

            if( strlen($post['password']) < 8)
                $errors[] = "Désolé, votre mot de passe doit contenir plus de 8 caractères";

            if (count($errors)) {
                return Views::render('user.register', ["errors" => $errors]);
            } else {

                $user = new User;
                $user->login = $post['login'];
                $user->firstname = $post['firstname'];
                $user->lastname = $post['lastname'];
                $user->email = $post['email'];
                $user->picture = "https://lorempixel.com/640/480/?29141";
                $user->password = password_hash($post['password'], PASSWORD_DEFAULT);
                $user->biography = $post['biography'];
                $user->price = $post['price'];
                $user->save();

                return Views::render('hello', ["games" => Game::findAll()]);
            }
        }

        return Views::render('user.register', []);

    }

    public function loginAction($params)
    {
        $post = $params['POST'];
        $errors = null;

        if(isset($post['login']))
        {
            $user = User::findBy("login", $post['login']);

            if(count($user) === 0)
            {
                $errors[] = "Désolé, ce login n'existe pas";

                return Views::render('user.login', ['errors' => $errors]);
            }

            if(password_verify($post['password'], $user[0]->password))
                $token = $user[0]->generateToken();
            else{
                $errors[] = "Désolé, votre mot passe n'est pas bon";
                return Views::render('user.login', ['errors' => $errors]);
            }
        }

        return Views::render('user.login', []);
    }

    public function logoutAction()
    {
        $user = Auth::user();
        $user->token = "";
        $user->save();

        session_destroy();

        return Views::render('home', []);
    }
}
