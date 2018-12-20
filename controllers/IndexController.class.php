<?php

namespace Lag\Controller;

use \Lag\Model\Game;
use \Lag\Core\Views;

class IndexController
{

    public function indexAction()
    {
        $games = Game::findAll();

        return Views::render("home", array("games" => $games));
    }

}
