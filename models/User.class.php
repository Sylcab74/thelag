<?php

namespace Lag\Model;

use \Lag\Core\Table;

class User extends Table
{
    protected static $table_name = 'users';
    protected $fields_list = ['id','login', 'password', 'email', 'firstname', 'lastname', 'picture', 'availability'];

    public $id;
    public $login;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $picture;
    public $availability = [];
    public $games;

    public function addGame($gameId)
    {
        $query = "INSERT INTO link_games_users ( users_id, games_id ) VALUES ( " . $this->id . ", " . $gameId . " )";
        
        return $this->myQuery($query);
    }

    public function removeGame($gameId)
    {
        $query = "DELETE FROM link_games_users WHERE users_id = ". $this->id ." AND games_id = " . $gameId;
        
        return $this->myQuery($query);
    }

    public function games()
    {
        $this->games = [];

        $query = "SELECT games_id FROM link_games_users WHERE users_id = ". $this->id;
        $results = $this->myFetchAllAssoc($query);

        foreach ($results as $result) {
            $game = new Game;
            $game->id = $result['games_id'];
            $game->hydrate();
            $this->games[] = $game;
        }
    }
}