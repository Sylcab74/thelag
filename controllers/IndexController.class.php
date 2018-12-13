<?php

namespace Lag\Controller;

use \Lag\Model\Game;

class IndexController
{

    public function indexAction()
    {   
        $games = Game::findAll();

        return Views::render("hello", array("games" => $games));
    }

}