<?php

namespace Lag\Model;

use \Lag\Core\Table;

class Game extends Table
{
    protected static $table_name = 'games';
    protected $fields_list = ['id','name', 'type', 'picture', 'description'];

    public $id;
    public $name;
    public $type;
    public $picture;
    public $description;
}
