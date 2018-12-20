<?php

namespace Lag\Controller;

use \Lag\Model\{Game, User};
use \Lag\Core\Views;

class IndexController
{

    public function indexAction()
    {
        return Views::render('home');
    }

    public function searchAction($params)
    {
        $response = [];
        $result = [];
        $post = $params['POST'];

        if ($post['action'] === "jeu") {
            $games = (new Game)->search($post['search']);

            foreach($games as $game) {
                $objgame = new Game;
                $objgame->id = $game['id'];
                $objgame->hydrate();
                $result[] = $objgame;
            }
        } else {
            $users = (new User)->search($post['search']);

            foreach($users as $user) {
                $objuser = new User;
                $objuser->id = $user['id'];
                $objuser->hydrate();
                $result[] = $objuser;
            }
        }

        $response['status'] = 'success';
        $response['response'] = $result;

        echo json_encode($response);
    }

}
