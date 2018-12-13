<?php


class IndexController
{

    public function indexAction()
    {        
        $games = Game::findAll();

        return Views::render("hello", array("games" => $games));
    }

}