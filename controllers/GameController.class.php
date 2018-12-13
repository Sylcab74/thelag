<?php


class GameController
{

    public function listAction()
    {        
        $games = Game::findAll();

        return Views::render("hello", array("games" => $games));
    }

    public function showAction($params)
    {
        $game = new Game();

        $game->id = $params["URL"][0];

        $game->hydrate();

        echo "<pre>";
        var_dump($game);
        echo "</pre>";

        return Views::render("games.show", array("game" => $game));
    }
}