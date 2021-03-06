<?php

namespace Lag\Controller;

use \Lag\Service\Calendar;
use \Lag\Core\{Views, Auth};
use \Lag\Model\{User, Game};

class UserController
{
    public function editAction($params)
    {
        $post = $params['POST'];

        $response = [];

        $user = new User;
        $user->id = $params['URL'][0];
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

    public function updateAction($params)
    {
        $user = new User;
        $user->id = $params['URL'][0];
        $user->hydrate();
        $user->games();

        return Views::render("user.update", [ "user" => $user ]);
    }

    public function profilAction()
    {
        $user = Auth::user();
        $user->games();
        $games = $user->games;


        $objCalendar = new Calendar;
        $calendar = $objCalendar->createCalendar($user);
        $days = $objCalendar->days;

        end($calendar);
        $end = key($calendar);
        reset($calendar);

        return Views::render("user.profil", [
            "calendar" => $calendar,
            "user" => $user,
            "games" => $games,
            "days" => $days,
            'year' => date('Y'),
            "month" => date('m'),
            "start" => key($calendar),
            "end" => $end
        ]);
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

                return Views::render('home', ["games" => Game::findAll()]);
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

            if(count($user) === 0)  {
                $errors[] = "Désolé, ce login n'existe pas";

                return Views::render('user.login', ['errors' => $errors]);
            }

            if(password_verify($post['password'], $user[0]->password))
                $user[0]->generateToken();
            else{
                $errors[] = "Désolé, votre mot passe n'est pas bon";
                return Views::render('user.login', ['errors' => $errors]);
            }
            return Views::render('home', []);
        }

        return Views::render('user.login', []);
    }

    public function logoutAction()
    {
        $user = Auth::user();
        $user->token = "";
        $user->save();

        unset($_SESSION);
        session_destroy();

        header('Location: /');
    }
}
