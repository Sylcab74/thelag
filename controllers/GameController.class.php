<?php

namespace Lag\Controller;

use \Lag\Model\Game;
use \Lag\Model\User;
use \Lag\Core\Views;

class GameController
{
    public function indexAction()
    {   
        $games = Game::findAll();

        return Views::render("games.index", array("games" => $games));
    }

    public function showAction($params)
    {
        $user = new User;
        $user->id = 2;
        $user->games();

        $game = new Game;
        $game->id = $params['URL'][0];
        $game->hydrate();
        $getThisGame = in_array($game, $user->games);
        
        return Views::render("games.show", array(
            "game" => $game,
            "getThisGame" => $getThisGame
        ));
    }

    public function searchAction($params)
    {

        $response = [];
        $result = [];
        $post = $params['POST'];

        $games = (new Game)->search($post['search']);

        foreach($games as $game) {
            $objgame = new Game;
            $objgame->id = $game['id'];
            $objgame->hydrate();
            $result[] = $objgame;
        }

        $response['status'] = 'success';
        $response['response'] = $result;

        echo json_encode($response);
    }
}