<?php

namespace Lag\Controller;

use \Lag\Model\Game;
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
        $game = new Game;
        $game->id = $params['URL'][0];
        $game->hydrate();

        return Views::render("games.show", array(
            "game" => $game,
            "description" => $game->description
        ));
    }
}